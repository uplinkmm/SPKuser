<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Betting\BettingInterface;
use Illuminate\Http\Request;

class BettingController extends Controller
{
    //

    private $bettingRepo;
    public function __construct(BettingInterface $repo)
    {
        $this->bettingRepo = $repo;
    }

    public function createBetting(Request $request){
        $data=$this->bettingRepo->createBetting($request);
        ResponseData($data);
    }

    public function getBetNumberList(Request $request){
        $data=$this->bettingRepo->getBettingNumberList($request);
        ResponseData($data);
    }

    public function getBettingHistory(Request $request){
        $data=$this->bettingRepo->getBettingHistory($request);
        ResponseData($data);
    }

    public function getWinningList(Request $request){
        $data=$this->bettingRepo->getWinningList($request);
        ResponseData($data);
    }

    public function getWinningNumberList(Request $request){
        $data=$this->bettingRepo->getWinningNumberList($request);
        ResponseData($data);
    }
}
