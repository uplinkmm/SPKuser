<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use App\Http\Requests\CashWithdrawl\CreateWithdrawlRequest;

use App\Models\Customer;

use App\Repositories\CashWithdrawlTransaction\CashWithdrawlTransactionRepositoryInterface;

class CashWithdrawlTransactionAPIController extends Controller
{
    //
    private $withdrawlRepo;

    public function __construct(CashWithdrawlTransactionRepositoryInterface $repo)
    {
        $this->withdrawlRepo = $repo;
    }

    public function createWithdrawl(CreateWithdrawlRequest $request)
    {
        $customer = Customer::find(ApiUser()->id);
        // if(!Hash::check($request->password, $customer->getAuthPassword())){
        //     ResponseMessage('Password is Invalid', 401);
        // }
        $data = $request->all();
        $data['customer_id'] = $customer->id;
        $withdrawl = $this->withdrawlRepo->createTransaction($data);
        if($withdrawl){
            ResponseData($withdrawl, 200, true, 'Cash withdrawal requested');
        }
        else{
            ResponseMessage('Cash withdrawal request failed', 500);
        }
    }
}
