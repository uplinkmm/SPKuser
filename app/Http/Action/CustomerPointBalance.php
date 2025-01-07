<?php
namespace App\Http\Action;

use App\Models\CustomerPointBag;

class CustomerPointBalance{

    private $customerId;
    public function __construct($customerId)
    {
        $this->customerId=$customerId;
    }
    public function getCustomerPointBalance(){
        $customerPoint = CustomerPointBag::where('customer_id', $this->customerId)->first();
        $balance=$customerPoint ? $customerPoint->balance :0;
        return $balance;
    }
}