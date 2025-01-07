<?php

namespace App\Repositories\Seamless;

interface SeamlessInterface
{
    public function getGameBalance($request);

    public function placeBet($request);

    public function gameResult($request);

    
    
}