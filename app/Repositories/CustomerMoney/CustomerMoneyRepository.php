<?php

namespace App\Repositories\CustomerMoney;

use stdClass;
use App\Enums\TransactionName;
use App\Models\CustomerWallet;
use App\Services\WalletService;
use App\Models\CustomerPointBag;
use App\Models\TopupTransaction;
use App\Models\WalletTransaction;
use App\Models\CustomerGameWallet;
use Illuminate\Support\Facades\DB;
use App\Models\CashWithdrawlTransaction;
use App\Http\Action\CustomerPointBalance;
use App\Http\Action\CustomerWalletBalance;
use App\Http\Action\WalletTransactionCommon;

class CustomerMoneyRepository implements CustomerMoneyRepositoryInterface
{
    use WalletTransactionCommon;
    public function createPointBag(int $customerId)
    {
        if (CustomerPointBag::where('customer_id', $customerId)->first()) {
            // point bag already exists for customer
            return null;
        }
        $prefix = null;
        if ($customerId < 10) {
            $prefix = sprintf('PB000%d', $customerId);
        } else if ($customerId > 10 && $customerId < 100) {
            $prefix = sprintf('PB00%d', $customerId);
        } else if ($customerId > 100 && $customerId < 1000) {
            $prefix = sprintf('PB0%d', $customerId);
        } else {
            $prefix = 'PB' . $customerId;
        }
        $bagId = $prefix . now()->format('Ymd');

        $pointBag = CustomerPointBag::create([
            'customer_id' => $customerId,
            'bagId' => $bagId,
            'balance' => 0,
        ]);

        return $pointBag;
    }

    public function createWallet($customerId)
    {
        if (CustomerWallet::where('customer_id', $customerId)->first()) {
            // point bag already exists for customer
            return null;
        }
        $prefix = null;
        if ($customerId < 10) {
            $prefix = sprintf('WL000%d', $customerId);
        } else if ($customerId > 10 && $customerId < 100) {
            $prefix = sprintf('WL00%d', $customerId);
        } else if ($customerId > 100 && $customerId < 1000) {
            $prefix = sprintf('WL0%d', $customerId);
        } else {
            $prefix = 'WL' . $customerId;
        }
        $walletId = $prefix . now()->format('Ymd');

        $wallet = CustomerWallet::create([
            'customer_id' => $customerId,
            'walletId' => $walletId,
            'balance' => 0,
        ]);

        return $wallet;
    }
    public function createGameWallet($customer){
        // if (CustomerGameWallet::where('customer_id', $customer->id)->first()) {
        //     // point bag already exists for customer
        //     return null;
        // }
        (new WalletService)->deposit($customer, 100000, TransactionName::CapitalDeposit);
        // $wallet = CustomerGameWallet::create([
        //     'customer_id' => $customerId,
        // ]);
        // return $wallet;
    }

    public function moneyBalances($customerId)
    {
        // dd(UserData()->balanceFloat);
        // $pointBag = CustomerPointBag::where('customer_id', $customerId)->first();
        $pointBag=(new CustomerPointBalance($customerId))->getCustomerPointBalance();
        $customerWalletBalance=(new CustomerWalletBalance($customerId))->getCustomerWalletBalance();
        // $customerGameBalance=(new CustomerWalletBalance($customerId))->getCustomerGameBalnce();
        $main_money=new stdClass();
        $main_money->balance=$customerWalletBalance;    
        $game_money=new stdClass();
        // $game_money->balance=$customerGameBalance;
        $game_money->balance=UserData()->balanceFloat;
        
        return ['main_money' => $main_money, 'game_money' => $game_money];
    }

    public function getCustomerWalletMoney($customerId){
        $balance=(new CustomerWalletBalance($customerId))->getCustomerWalletBalance();
        return ['wallet_balance'=>$balance];
    }

    public function getTransactionHistory($request){
        $customerId=UserData()->id;
        $className= $request->type=='topup_transaction' ? TopupTransaction::class : CashWithdrawlTransaction::class ;
        $transactions=$className::with(['account:id,account_type,phone_number'])
        ->orderBy('id','desc')
        ->where('customer_id',$customerId)
        ->select('id','customer_id','amount','status','confirmed_at','rejected_at','remark','account_id',
        DB::raw("CASE 
        WHEN status = 'pending' THEN created_at
        WHEN status = 'confirmed' THEN confirmed_at
        WHEN status = 'rejected' THEN rejected_at
        END AS date")
        )
        ->paginate(20);
        return $transactions;
    }
}
