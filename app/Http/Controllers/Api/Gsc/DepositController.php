<?php

namespace App\Http\Controllers\Api\Gsc;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\GameType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\GameTypeProduct;
use Illuminate\Support\Facades\Redis;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Gsc\GscWebhookRequest;

class DepositController extends Controller
{
    //
    use GscWtihdrawProcess;
    public function withdraw(GscWebhookRequest $request)
    {
        $userId = $request->getMember()->id;
        // Retry logic for acquiring the Redis lock
        //tem command for redis
        $attempts = 0;
        $maxAttempts = 3;
        $lock = false;

        // while ($attempts < $maxAttempts && !$lock) {
        //     $lock = Redis::set("wallet:lock:$userId", true, 'EX', 15, 'NX'); // 15 seconds lock
        //     $attempts++;

        //     if (!$lock) {
        //         sleep(1); // Wait for 1 second before retrying
        //     }
        // }
        // if (!$lock) {
        //     return response()->json([
        //         'message' => 'Another transaction is currently processing. Please try again later.',
        //         'userId' => $userId,
        //     ], 409); // 409 Conflict
        // }
        //end redis

        $validator = $request->check();

        if ($validator->fails()) {
            // Release Redis lock and return validation error response
            // tem redis
            // Redis::del("wallet:lock:$userId");
            // temp redis

            return $validator->getResponse();
        }
        $transactions = $validator->getRequestTransactions();
        // Check if the transactions are in the expected format
        if (!is_array($transactions) || empty($transactions)) {

            Redis::del("wallet:lock:$userId"); //tem redis

            return response()->json([
                'message' => 'Invalid transaction data format.',
                'details' => $transactions,  // Provide details about the received data for debugging
            ], 400);  // 400 Bad Request
        }
        $before_balance = $request->getMember()->balanceFloat;
        DB::beginTransaction();
        try {
            // Create and store the event in the database
            $event = $this->createEvent($request);
            // Insert bets using chunking for better performance
            $message = $this->insertBets($transactions, $event);  // Insert bets in chunks

            // DB::commit();  // Commit only the bet insertion

        } catch (\Exception $e) {
            DB::rollBack();
            Redis::del("wallet:lock:$userId");
            Log::error('Error during placeBet', ['error' => $e]);

            return response()->json(['message' => $e->getMessage()], 500);
        }
        try {
            foreach ($transactions as $transaction) {
                // Assuming 'from' user is the one placing the bet and 'to' is the admin or system wallet
                $fromUser = $request->getMember();
                $toUser = User::adminUser();  // Admin or central system wallet

                // Fetch the rate from GameTypeProduct before calling processTransfer()
                $game_type = GameType::where('code', $transaction->game_type)->first();
                $product = Product::where('code', $transaction->product_code)->first();
                $game_type_product = GameTypeProduct::where('game_type_id', $game_type->id)
                    ->where('product_id', $product->id)
                    ->first();
                // Use the rate from GameTypeProduct or fallback to a default value
                $rate = (int) ($game_type_product->rate ?? 1);
                $meta = [
                    'wager_id' => $transaction->wager_code,               // Use object property access
                    'event_id' => $request->getMessageID(),
                    'seamless_transaction_id' => $transaction->id,  // Use object property access
                ];
                // dd($transaction);

                $action = $transaction->action;

                // Call processTransfer for each transaction
                $this->processTransfer(
                    $fromUser,                        // From user
                    $toUser,                          // To user (admin/system wallet)
                    $transaction->action,           // Transaction name (e.g., Stake)
                    $transaction->amount,  // Use object property access for TransactionAmount
                    $rate,                            // Use the fetched rate or default value
                    $meta                             // Meta data (wager id, event id, et  c.)
                );

                //for my system 
                // $this->processBetAmount(
                //     $fromUser,
                //     TransactionName::Stake,           // Transaction name (e.g., Stake)
                //     $transaction->TransactionAmount,  // Use object property access for TransactionAmount
                //     $rate,                            // Use the fetched rate or default value
                //     $meta
                // );
            }

            // Refresh balance after transactions
            $request->getMember()->wallet->refreshBalance();
            $after_balance = $request->getMember()->balanceFloat;

        } catch (\Exception $e) {
            Log::error('Error during wallet transfer processing', ['error' => $e]);
            Redis::del("wallet:lock:$userId");
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // Release the Redis lock
        // Redis::del("wallet:lock:$userId");

        // Return success response
        return SlotWebhookService::buildGscResponse(
            SlotWebhookResponseCode::Success,
            $request->getMember()->user_name,
            $request->getProductID(),
            $after_balance,
            $before_balance
        );
    }
}
