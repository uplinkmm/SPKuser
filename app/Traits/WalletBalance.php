<?php
namespace App\Traits;

use App\Models\CustomerGameWallet;

trait WalletBalance{
    public function getGameBalanceByCustomerId($customeId){
        $customeWallet=CustomerGameWallet::where('customer_id',$customeId)->first();
        if(!$customeWallet){
            ResponseMessage("Customer donesn't exist at wallet ",422);
        }
        return $customeWallet;
        // $balance=$customeWallet ? $customeWallet->balance : 0;
        // return $balance;
    }
}