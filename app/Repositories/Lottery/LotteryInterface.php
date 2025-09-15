<?php

namespace App\Repositories\Lottery;

use Illuminate\Http\Request;

interface LotteryInterface
{
    public function list($request);
   public function createLottery($request);
   public function detail($id);

}