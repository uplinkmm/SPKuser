<?php

namespace App\Repositories\WalletTransfer;

use App\Models\User;
use App\Enums\TransactionName;
use App\Models\CustomerWallet;
use App\Models\WalletTransfer;
use App\Services\WalletService;
use App\Http\Action\BuildWallet;
use App\Models\CustomerGameWallet;
use Illuminate\Support\Facades\DB;
use App\Http\Action\WalletTransactionCommon;

class WalletTransferRepository implements WalletTransferInterface
{
    use WalletTransactionCommon;

    //old
    
    // public function createWalletTransfer($request)
    // {
    //     // return $request->all();
    //     DB::transaction(function () use ($request) {
    //         $customerId = $request->customer_id;
    //         $amount = $request->amount;
    //         $transferType = $request->transfer_type;
    //         $customerWallet = CustomerWallet::where('customer_id', $customerId)->first();
    //         if (!$customerWallet) {
    //             $customerWallet = (new BuildWallet())->createWallet($customerId);
    //         }
    //         //changes for walletable
    //         // $gameWallet = CustomerGameWallet::where('customer_id',$customerId)->first();
    //         // if(!$gameWallet){
    //         //     $gameWallet=(new BuildWallet())->createGameWallet($customerId);
    //         // }
    //         //endwallet
    //         $customer = UserData();
    //         $gameWalletBalance = UserData()->balanceFloat;
    //         $adminUser = User::adminUser();
    //         if ($transferType === 'to_game') {
    //             // Ensure sufficient balance in the main wallet
    //             if ($customerWallet->balance < $amount) {
    //                 ResponseMessage('Insufficient wallet balance.', 422);
    //                 // throw new \Exception('Insufficient wallet balance.');
    //             }
    //             //customer wallet
    //             $customerWallet->balance -= $amount;
    //             $customerWallet->out_balance += $amount;
    //             //game wallet
    //             // $gameWallet->game_balance += $amount;
    //             // $gameWallet->in_balance += $amount;
    //             // $gameWallet->balance += $amount;
    //             (new WalletService)->deposit($customer, $amount, TransactionName::GameMoneyTransfer);
    //             // app(WalletService::class)->transfer($customer, $customer, $amount, TransactionName::GameMoneyTransfer);


    //         } elseif ($transferType === 'to_wallet') {
    //             // Ensure sufficient balance in the game wallet
    //             if ($gameWalletBalance < $amount) {
    //                 ResponseMessage('Insufficient game wallet balance.', 422);
    //                 throw new \Exception('Insufficient game wallet balance.');
    //             }
    //             // //game wallet
    //             // $gameWallet->game_balance -= $amount;
    //             // $gameWallet->out_balance += $amount;
    //             // $gameWallet->balance -= $amount;
    //             (new WalletService)->withdrawal($customer, $amount, TransactionName::MainMoneyTransfer);
    //             //customer wallet
    //             $customerWallet->balance += $amount;
    //             $customerWallet->in_balance += $amount;
    //         }

    //         $customerWallet->save();
    //         // $gameWallet->save();

    //         //tem command for walletable
    //         WalletTransfer::create([
    //             'customer_id' => $customerId,
    //             'transfer_type' => $transferType,
    //             'amount' => $amount,
    //             'previous_balance' => $transferType === 'to_game'
    //                 ? $customerWallet->balance + $amount
    //                 : UserData()->balanceFloat + $amount,
    //             'new_balance' => $transferType === 'to_game'
    //                 ? $customerWallet->balance
    //                 : UserData()->balanceFloat,
    //         ]);
    //     });
    // }

    public function createWalletTransfer($request)
    {
        // return $request->all();
        DB::transaction(function () use ($request) {
            $customerId = $request->customer_id;
            $amount = $request->amount;
            $transferType = $request->transfer_type;
            $customerWallet = CustomerWallet::where('customer_id', $customerId)->first();
            if (!$customerWallet) {
                $customerWallet = (new BuildWallet())->createWallet($customerId);
            }
            //changes for walletable
            // $gameWallet = CustomerGameWallet::where('customer_id',$customerId)->first();
            // if(!$gameWallet){
            //     $gameWallet=(new BuildWallet())->createGameWallet($customerId);
            // }
            //endwallet
            $customer = UserData();
            $gameWalletBalance = UserData()->balanceFloat;
            $adminUser = User::adminUser();
            $walletTransfer = WalletTransfer::create([
                'customer_id' => $customerId,
                'transfer_type' => $transferType,
                'amount' => $amount,
                'previous_balance' => $transferType === 'to_game'
                    ? $customerWallet->balance + $amount
                    : UserData()->balanceFloat + $amount,
                'new_balance' => $transferType === 'to_game'
                    ? $customerWallet->balance
                    : UserData()->balanceFloat,
            ]);
            if ($transferType === 'to_game') {
                // Ensure sufficient balance in the main wallet
                if ($customerWallet->balance < $amount) {
                    ResponseMessage('Insufficient wallet balance.', 422);
                    // throw new \Exception('Insufficient wallet balance.');
                }
                //customer wallet
                $customerWallet->balance -= $amount;
                $customerWallet->out_balance += $amount;
                //game wallet
                // $gameWallet->game_balance += $amount;
                // $gameWallet->in_balance += $amount;
                // $gameWallet->balance += $amount;
                (new WalletService)->deposit($customer, $amount, TransactionName::GameMoneyTransfer);
                $this->actionOfWalletTransaction($walletTransfer, $amount, 'out');
                // app(WalletService::class)->transfer($customer, $customer, $amount, TransactionName::GameMoneyTransfer);


            } elseif ($transferType === 'to_wallet') {
                // Ensure sufficient balance in the game wallet
                if ($gameWalletBalance < $amount) {
                    ResponseMessage('Insufficient game wallet balance.', 422);
                    throw new \Exception('Insufficient game wallet balance.');
                }
                // //game wallet
                // $gameWallet->game_balance -= $amount;
                // $gameWallet->out_balance += $amount;
                // $gameWallet->balance -= $amount;
                (new WalletService)->withdrawal($customer, $amount, TransactionName::MainMoneyTransfer);
                $this->actionOfWalletTransaction($walletTransfer, $amount, 'in');
                //customer wallet
                $customerWallet->balance += $amount;
                $customerWallet->in_balance += $amount;
            }

            $customerWallet->save();
            // $gameWallet->save();

            //tem command for walletable

        });
    }
}