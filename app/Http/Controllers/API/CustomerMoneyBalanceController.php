<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Repositories\CustomerMoney\CustomerMoneyRepositoryInterface;

class CustomerMoneyBalanceController extends Controller
{
    //
    private $moneyRepo;

    public function __construct(CustomerMoneyRepositoryInterface $repo)
    {
        $this->moneyRepo = $repo;
    }

    public function getBalances(Request $request)
    {
        $balance = $this->moneyRepo->moneyBalances(ApiUser()->id);
        ResponseData($balance);
    }

    public function getCustomerWalletMoney(){
        $balance = $this->moneyRepo->getCustomerWalletMoney(ApiUser()->id);
        ResponseData($balance);
    }

    public function getTransactionHistory(Request $request){
        $transactions = $this->moneyRepo->getTransactionHistory($request);
        ResponseData($transactions);
    }
}
