<?php

namespace App\Http\Controllers\Api\Gsc;

use App\Models\User;
use App\Enums\CurrencyRate;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Enums\TransactionName;
use App\Models\Admin\GameType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Admin\GameTypeProduct;
use Illuminate\Support\Facades\Redis;
use App\Enums\SlotWebhookResponseCode;
use App\Services\Slot\SlotWebhookService;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Http\Controllers\Api\V1\Webhook\Traits\GscWebhook;
use App\Http\Controllers\Api\Gsc\GscWebhook\GscWtihdrawProcess;

class DepositController extends Controller
{
    //
    // use GscWtihdrawProcess;
    use GscWebhook;
    public function deposit(GscWebhookRequest $batchRequest)
    {
        $data = [];
        foreach ($batchRequest['batch_requests'] as $batch) {
            $request = new GscWebhookRequest($batch);
            $request['operator_code'] = $batchRequest->operator_code;
            $request['sign'] = $batchRequest->sign;
            $request['request_time'] = $batchRequest->request_time;
            $request['url'] = $batchRequest->url();
            $request['currency']=$batchRequest->currency;
            $userId = $request->getMember() ? $request->getMember()->id : null;
            $currencyRate = CurrencyRate::fromName($batchRequest->currency);
            if (!$currencyRate) {
                return SlotWebhookService::buildGscResponse(
                    SlotWebhookResponseCode::InternalServerError,
                    $request->getMember()->user_name,
                    $request->getProductID(),
                    $request->getMember() ? $request->getMember()->balanceFloat : 0,
                    $request->getMember() ? $request->getMember()->balanceFloat : 0,
                    1,
                );
            }
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
                $data[] = $validator->getResponse();
                return response()->json([
                    'data' => $data
                ]);
            }
            // $transactions = $validator->getRequestTransactions();
            // Check if the transactions are in the expected format
            // if (!is_array($transactions) || empty($transactions)) {

            //     Redis::del("wallet:lock:$userId"); //tem redis

            //     return response()->json([
            //         'message' => 'Invalid transaction data format.',
            //         'details' => $transactions,  // Provide details about the received data for debugging
            //     ], 400);  // 400 Bad Request
            // }
            $before_balance = $request->getMember() ? $request->getMember()->balanceFloat : 0;
            DB::beginTransaction();
            try {
                // Create and store the event in the database
                $event = $this->createEvent($request);
                // Insert bets using chunking for better performance
                $seamless_transactions = $this->createWagerTransactions($validator->getRequestTransactions(), $event);
                foreach ($seamless_transactions as $seamless_transaction) {
                    $from = User::adminUser();
                    $to = $request->getMember();
                    // if ($seamless_transaction->transaction_amount < 0) {
                    //     $from = $request->getMember();
                    //     $to = User::adminUser();
                    // } else {
                    //     $from = User::adminUser();
                    //     $to = $request->getMember();
                    // }
                    $this->processTransfer(
                        $from,
                        $to,
                        TransactionName::from($seamless_transaction->status),
                        $seamless_transaction->transaction_amount,
                        $seamless_transaction->rate,
                        [
                            'wager_id' => $seamless_transaction->wager_id,
                            'event_id' => $request->getMessageID(),
                            'seamless_transaction_id' => $seamless_transaction->id,
                        ]
                    );
                }
                // $message = $this->insertBets($transactions, $event);  // Insert bets in chunks

                $request->getMember()->wallet->refreshBalance();

                $after_balance = $request->getMember()->balanceFloat;

                DB::commit();  // Commit only the bet insertion
                $data[] = SlotWebhookService::buildGscResponse(
                    SlotWebhookResponseCode::Success,
                    $request->getMember()->user_name,
                    $request->getProductID(),
                    $after_balance,
                    $before_balance,
                    $currencyRate->value
                );
                // return SlotWebhookService::buildGscResponse(
                //     SlotWebhookResponseCode::Success,
                //     $request->getMember()->user_name,
                //     $request->getProductID(),
                //     $after_balance,
                //     $before_balance
                // );
            } catch (\Exception $e) {
                DB::rollBack();
                Redis::del("wallet:lock:$userId");
                Log::error('Error during placeBet', ['error' => $e]);

                return response()->json(['message' => $e->getMessage()], 500);
            }

            // Release the Redis lock
            // Redis::del("wallet:lock:$userId");

            // Return success response

        }
        return response()->json([
            'data' => $data
        ]);
    }
}
