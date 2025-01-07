<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\Topup\CreateTopupRequest;

use App\Repositories\TopupTransaction\TopupTransactionRepositoryInterface;

class TopupTransactionAPIController extends Controller
{
    //
    private $topupRepo;

    public function __construct(TopupTransactionRepositoryInterface $repo)
    {
        $this->topupRepo = $repo;
    }

    public function createTopup(CreateTopupRequest $request)
    {
        $data = $request->all();
        $data['customer_id'] = ApiUser()->id;
        $topup = $this->topupRepo->createTransaction($data);
        if($topup){
            ResponseData($topup, 200, true, 'Topup success');
        }
        else{
            ResponseMessage('Topup failed', 500);
        }
    }
}
