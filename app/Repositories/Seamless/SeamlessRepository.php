<?php

namespace App\Repositories\Seamless;

use App\Http\Action\WalletTransactionCommon;
use App\Traits\WalletBalance;
use App\Models\SlotTransaction;
use App\Models\CustomerGameWallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\SlotTransactionBalance;

class SeamlessRepository implements SeamlessInterface
{
    use WalletBalance, WalletTransactionCommon;
    public function getGameBalance($request)
    {
        $customeId = $request->MemberName;
        $gameBalance = $this->getGameBalanceByCustomerId($customeId);
        // $balance=$customeWallet ? $customeWallet->balance : 0;
        return response()->json([
            'ErrorCode' => 0,
            'ErrorMessage' => "success",
            'Balance' => $gameBalance->balance,
            'BeforeBalance' => 0,
        ]);
    }

    private function makeRequest($endpoint, $data)
    {
        $url = env('STAGING_URL') . $endpoint;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body()
            ], $response->status());
        }
    }

    public function placeBet($request)
    {
        // return $request->Transactions;
        DB::beginTransaction();
        try {
            $customerId = $request->MemberName;
            $transactions = $request->Transactions;
            foreach ($transactions as $transaction) {
                $transactionAmount = $transaction['TransactionAmount'];
                $gameBalance = $this->getGameBalanceByCustomerId($customerId);
                $afterBalance = $gameBalance->balance + ($transaction['TransactionAmount']);
                $gameAfterBalance = $gameBalance->game_balance + ($transaction['TransactionAmount']);
                if ($gameAfterBalance < 0) {
                    return response()->json([
                        'ErrorCode' => 1,
                        'ErrorMessage' => "Insufficient balance for transaction",
                    ], 422);
                }
                if ($transactionAmount > 0) {
                    $gameBalance->in_balance += abs($transactionAmount);
                } elseif ($transactionAmount < 0) {
                    $gameBalance->out_balance += abs($transactionAmount);
                }
                $gameBalance->balance = $afterBalance;
                $gameBalance->game_balance = $gameAfterBalance;
                $beforeBalance = $gameBalance->balance;
                $gameBalance->save();
                $slotTransaction = $this->storeSlotTransaction($customerId, $transaction);
                $this->actionOfWalletTransaction($slotTransaction, $slotTransaction->bet_amount, 'in');
            }
            DB::commit();
            return response()->json([
                'ErrorCode' => 0,
                'ErrorMessage' => "success",
                'Balance' => $gameBalance->balance,
                'BeforeBalance' => $beforeBalance,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'ErrorCode' => 1,
                'ErrorMessage' => $e->getMessage(),
            ]);
        }
    }

    public function gameResult($request)
    {
        DB::beginTransaction();
        try {
            $customerId = $request->MemberName;
            $transactions = $request->Transactions;
            foreach ($transactions as $transaction) {
                $payoutAmount = $transaction['PayoutAmount'];
                $gameBalance = $this->getGameBalanceByCustomerId($customerId);
                $beforeBalance = $gameBalance->balance;
                // dd($beforeBalance);
                $afterBalance = $gameBalance->balance + $payoutAmount;
                $gameAfterBalance = $gameBalance->game_balance + $payoutAmount;
               
                if ($payoutAmount > 0) {
                    $gameBalance->in_balance += $payoutAmount;
                } 
                $gameBalance->balance = $afterBalance;
                $gameBalance->game_balance = $gameAfterBalance;
                $gameBalance->save();
                // dd($gameBalance);
                $slotTransaction = $this->storeSlotTransaction($customerId, $transaction);
                $this->actionOfWalletTransaction($slotTransaction, $slotTransaction->payout_amount, 'out');
            }
            DB::commit();
            return response()->json([
                'ErrorCode' => 0,
                'ErrorMessage' => "success",
                'Balance' => $gameBalance->balance,
                'BeforeBalance' => $beforeBalance,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'ErrorCode' => 1,
                'ErrorMessage' => $e->getMessage(),
            ]);
        }
    }
    public function storeSlotTransaction($customeId, $transaction)
    {
        $slotTransaction = SlotTransaction::create([
            'customer_id' => $customeId,
            'member_id' => $transaction['MemberID'],
            'product_id' => $transaction['ProductID'],
            'provider_id' => $transaction['ProviderID'],
            'provider_line_id' => $transaction['ProviderLineID'],
            'wager_id' => $transaction['WagerID'],
            'currency_id' => $transaction['CurrencyID'],
            'game_type' => $transaction['GameType'],
            'game_id' => $transaction['GameID'],
            'game_round_id' => $transaction['GameRoundID'],
            'bet_amount' => $transaction['BetAmount'],
            'payout_amount' => $transaction['PayoutAmount'],
            'transaction_amount' => $transaction['TransactionAmount'],
            'transaction_id' => $transaction['TransactionID'],
            'commission_amount' => $transaction['CommissionAmount'],
            'jackpot_amount' => $transaction['JackpotAmount'],
            'settlement_date' => convertDateTimeFormat($transaction['SettlementDate']),
            'status' => $transaction['Status'],
        ]);
        return $slotTransaction;
    }

}