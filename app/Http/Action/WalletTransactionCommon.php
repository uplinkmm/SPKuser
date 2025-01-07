<?php
namespace App\Http\Action;

use Illuminate\Support\Str;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;

trait WalletTransactionCommon 
{

    public function actionOfWalletTransaction($data,$amount,$action){
        $morphMapName = RelationMorphName($data);
        $bettingTransaction=WalletTransaction::create([
            'date_time'=>now(),
            'amount'=>(int)$amount,
            'walletable_id'=>$data->id,
            'walletable_type'=>$morphMapName,
            'action'=>$action,
            'customer_id'=>$data->customer_id,
        ]);
        return $bettingTransaction;
    }

    public function getCustomerMainMoney($customerId){
        $wallet= WalletTransaction::join('customers', 'wallet_transactions.customer_id', 'customers.id')
            ->groupBy('customers.id', 'customers.name')
            ->select('customers.id as customer_id',
                DB::raw('SUM(CASE WHEN action = "in" THEN amount ELSE 0 END) as in_balance'),
                DB::raw('SUM(CASE WHEN action = "out"  THEN amount ELSE 0 END) as out_balance'),
                DB::raw('(SUM(CASE WHEN action = "in" THEN amount ELSE 0 END) -
        SUM(CASE WHEN action = "out"  THEN amount ELSE 0 END)) as balance'),
            )
            ->where('customers.id', $customerId)
            ->first();
            $balance = $wallet ? $wallet->balance : 0;
            return $balance;
            
    }

}