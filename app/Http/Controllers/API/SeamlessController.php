<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Seamless\SeamlessInterface;
use Illuminate\Http\Request;

class SeamlessController extends Controller
{
    private $seamlessRepo;
    public function __construct(SeamlessInterface $repo){
        $this->seamlessRepo=$repo;
    }

    public function getGameBalance(Request $request){
        return $this->seamlessRepo->getGameBalance($request);
    }

    public function placeBet(Request $request){
        return $this->seamlessRepo->placeBet($request);
    }

    public function gameResult(Request $request){
        return $this->seamlessRepo->gameResult($request);
    }
}
