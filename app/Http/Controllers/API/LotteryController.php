<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Lottery\LotteryInterface;

class LotteryController extends Controller
{
    //
    private $lotteryRepo;
    public function __construct(LotteryInterface $repo)
    {
        $this->lotteryRepo = $repo;
    }

    public function index(Request $request){
        $data=$this->lotteryRepo->list($request);
        ResponseData($data);
    }
    
    public function createLottery(Request $request){
        $data=$this->lotteryRepo->createLottery($request);
        ResponseData($data);
    }
    public function detail($id){
        $data=$this->lotteryRepo->detail($id);
        ResponseData($data);
    }
}
