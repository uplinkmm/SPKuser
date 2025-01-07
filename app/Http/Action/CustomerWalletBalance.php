<?php
namespace App\Http\Action;

use App\Models\CustomerGameWallet;
use App\Models\CustomerWallet;

class CustomerWalletBalance{

    private $customerId;
    public function __construct($customerId)
    {
        $this->customerId=$customerId;
    }
    public function getCustomerWalletBalance(){
        $customerWallet = CustomerWallet::where('customer_id', $this->customerId)->first();
        $balance=$customerWallet ? $customerWallet->balance :0;
        return $balance;
    }

    public function getCustomerGameBalnce(){
        $gameBalance = CustomerGameWallet::where('customer_id', $this->customerId)->first();
        $balance=$gameBalance ? $gameBalance->balance :0;
        return $balance;
    }


}