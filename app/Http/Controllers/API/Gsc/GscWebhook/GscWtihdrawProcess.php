<?php
namespace App\Http\Controllers\API\Gsc\GscWebhook;

use App\Models\Wager;
use App\Enums\WagerStatus;
use App\Models\Admin\Product;
use App\Models\SeamlessEvent;
use App\Enums\TransactionName;
use App\Http\Requests\Gsc\GscWebhookRequest;
use App\Models\Admin\GameType;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\GameTypeProduct;

trait GscWtihdrawProcess
{

    public function createEvent(GscWebhookRequest $request): SeamlessEvent
    {
        $formatted = date('Y-m-d H:i:s', $request->getRequestTime());
        return SeamlessEvent::create([
            'customer_id' => $request->getMember()->id, //'user_id' => $request->getMember()->id
            'message_id' => $request->getMessageID(),
            'product_id' => $request->getProductID(),
            'request_time' => $formatted,
            'raw_data' => $request->all(),
        ]);
    }
    public function insertBets(array $bets, SeamlessEvent $event)
    {
        $chunkSize = 50; // Define the chunk size
        $batches = array_chunk($bets, $chunkSize);
        $userId = $event->customer_id; // Get user_id from SeamlessEvent

        // Process chunks in a transaction to ensure data integrity
        DB::transaction(function () use ($batches, $event) {
            foreach ($batches as $batch) {
                // Call createWagerTransactions for each batch
                $this->createWagerTransactions($batch, $event);
            }
        });

        return count($bets) . ' bets inserted successfully.';
    }
    public function createWagerTransactions(array $betBatch, SeamlessEvent $event)
    {
        $retryCount = 0;
        $maxRetries = 5;
        $userId = $event->customer_id; // Get user_id from the SeamlessEvent// change from  $event->customer_id
        $seamlessEventId = $event->id; // Get the ID of the SeamlessEvent

        // Log the start of the transaction processing
        Log::debug("Starting createWagerTransactions for user ID: $userId, event ID: $seamlessEventId");

        // Retry logic for deadlock handling
        do {
            try {
                DB::transaction(function () use ($betBatch, $userId, $seamlessEventId) {
                    // Initialize arrays for batch inserts
                    $wagerData = [];
                    $seamlessTransactionsData = [];

                    // Log batch size being processed
                    Log::debug('Processing bet batch of size: ' . count($betBatch));

                    // Loop through each bet in the batch
                    foreach ($betBatch as $transaction) {
                        // Log transaction details
                        Log::debug('Processing transaction', ['transaction' => $transaction]);

                        // If transaction is an instance of the RequestTransaction object, extract the data
                        if ($transaction instanceof \App\Services\Gsc\Dto\GscRequestTransaction) {
                            // Attempt to retrieve the ActualGameTypeID from the database based on GameType
                            $gameType = GameType::where('code', $transaction->game_type)->first();
                            if ($gameType) {
                                $transaction->ActualGameTypeID = $gameType->id;
                            } else {
                                throw new \Exception('Invalid GameType: ' . $transaction->game_type);
                            }
                            // Attempt to retrieve the ActualProductID from the database based on ProductID
                            $product = Product::where('code', $transaction->product_code)->first();
                            if ($product) {
                                $transaction->ActualProductID = $product->id;
                            } else {
                                throw new \Exception('Invalid ProductID: ' . $transaction->product_code);
                            }
                            // Fetch the rate from GameTypeProduct
                            $game_type_product = GameTypeProduct::where('game_type_id', $gameType->id)
                                ->where('product_id', $product->id)
                                ->first();
                            if (!$game_type_product) {
                                throw new \Exception('GameTypeProduct combination not found.');
                            }

                            // Ensure rate is a valid integer, and provide a fallback if missing
                            $rate = (int) ($game_type_product->rate ?? 1);  // Cast rate to int with fallback value
                            // Build transaction data
                            $transactionData = [
                                'Status' => $transaction->wager_status,
                                'Action' => $transaction->action,
                                'ProductID' => $transaction->product_code,
                                'GameType' => $transaction->game_type,
                                'TransactionID' => $transaction->id,
                                'WagerID' => $transaction->wager_code,
                                'GameCode' => $transaction->game_code,
                                'WagerType' => $transaction->wager_type,
                                'BetAmount' => $transaction->bet_amount,
                                'TransactionAmount' => $transaction->amount,
                                'PayoutAmount' => $transaction->prize_amount,
                                'ValidBetAmount' => $transaction->valid_bet_amount,
                                'SettledAt' => $transaction->settled_at,
                                'Rate' => $rate,  // Use the fetched rate
                                'ActualGameTypeID' => $transaction->ActualGameTypeID,
                                'ActualProductID' => $transaction->ActualProductID,
                            ];


                        } else {
                            Log::error('Invalid transaction data format', ['transaction' => $transaction]);
                            throw new \Exception('Invalid transaction data format.');
                        }
                        // dd($transactionData);
                        // Now, use the $transactionData array as expected
                        $existingWager = Wager::where('seamless_wager_id', $transactionData['WagerID'])->lockForUpdate()->first();
                        // dd($existingWager);
                        if (!$existingWager) {
                            // Collect wager data for batch insert
                            $wagerData[] = [
                                'customer_id' => $userId,  // Use user_id from the SeamlessEvent
                                'seamless_wager_id' => $transactionData['WagerID'],
                                'wager_status' => $transactionData['Status'],
                                'wager_type' => $transactionData['WagerType'],
                                'status' => $transactionData['TransactionAmount'] > 0 ? WagerStatus::Win : WagerStatus::Lose,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
                        }
                        // Collect seamless transaction data for batch insert
                        $seamlessTransactionsData[] = [
                            'customer_id' => $userId,  // Use user_id from the SeamlessEvent
                            'wager_id' => $existingWager ? $existingWager->id : null,
                            'game_type_id' => $transactionData['ActualGameTypeID'],
                            'product_id' => $transactionData['ActualProductID'],
                            'seamless_transaction_id' => $transactionData['TransactionID'],
                            'game_code' => $transactionData['GameCode'],
                            'rate' => $transactionData['Rate'],
                            'transaction_amount' => $transactionData['TransactionAmount'],
                            'bet_amount' => $transactionData['BetAmount'],
                            'valid_amount' => $transactionData['ValidBetAmount'],
                            'payout_amount' => $transactionData['PayoutAmount'], //
                            'status' => $transactionData['Status'],
                            'action' => $transactionData['Action'],
                            'seamless_event_id' => $seamlessEventId,  // Include seamless_event_id
                            'settled_at' => $transactionData['SettledAt'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    // Perform batch inserts
                    if (!empty($wagerData)) {
                        Log::debug('Inserting wager data', ['wagerData' => $wagerData]);
                        DB::table('wagers')->insert($wagerData); // Insert wagers in bulk
                    }

                    if (!empty($seamlessTransactionsData)) {
                        Log::debug('Inserting seamless transactions data', ['seamlessTransactionsData' => $seamlessTransactionsData]);
                        DB::table('seamless_transactions')->insert($seamlessTransactionsData); // Insert transactions in bulk
                    }
                });
                Log::debug('createWagerTransactions completed successfully for event ID: ' . $seamlessEventId);
                break; // Exit the retry loop if successful

            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '40001') { // Deadlock error code
                    Log::warning('Deadlock detected, retrying...', ['retryCount' => $retryCount]);
                    $retryCount++;
                    if ($retryCount >= $maxRetries) {
                        Log::error('Max retries reached, throwing exception.', ['error' => $e]);
                        throw $e; // Max retries reached, fail
                    }
                    sleep(1); // Wait for a second before retrying
                } else {
                    Log::error('Query exception encountered', ['error' => $e]);
                    throw $e; // Rethrow if it's not a deadlock exception
                }
            }
        } while ($retryCount < $maxRetries);
    }

    public function processTransfer($from, $to, TransactionName $transactionName, float $amount, int $rate, array $meta)
    {
        $retryCount = 0;
        $maxRetries = 5;

        do {
            try {
                // Only lock the necessary rows inside the transaction
                DB::transaction(function () use ($from, $to, $amount, $transactionName, $meta) {
                    // Lock only the specific rows for the wallet that needs updating
                    $walletFrom = $from->wallet()->lockForUpdate()->firstOrFail();
                    $walletTo = $to->wallet()->lockForUpdate()->firstOrFail();

                    // dd($amount);
                    // dd($walletFrom->balance,$walletFrom->promotion_balance);
                    // Update wallet balances
                    $walletFrom->balance -= $amount;
                    $walletTo->balance += $amount;

                    //update promotion balanec
                    $deduction = abs($amount) * (10 ** $walletFrom->decimal_places);
                    if ($walletFrom->promotion_balance >= abs($deduction)) {
                        $walletFrom->promotion_balance -= abs($deduction);
                    } else {
                        $walletFrom->promotion_balance = 0;
                    }
                    // Save the updated balances
                    $walletFrom->save();
                    $walletTo->save();
                    // dd($walletFrom->balance,$walletFrom->promotion_balance);
                    // Perform the transfer in the wallet service (possibly outside the transaction)
                    app(WalletService::class)->transfer($from, $to, abs($amount), $transactionName, $meta);
                });

                break;  // Exit loop if successful

            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '40001') {  // Deadlock error code
                    $retryCount++;
                    if ($retryCount >= $maxRetries) {
                        throw $e;  // Max retries reached, fail
                    }
                    sleep(1);  // Wait before retrying
                } else {
                    throw $e;  // Rethrow non-deadlock exceptions
                }
            }
        } while ($retryCount < $maxRetries);
    }
}