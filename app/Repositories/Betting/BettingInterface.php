<?php
namespace App\Repositories\Betting;

interface BettingInterface
{

    public function createBetting($request);

    public function getBettingNumberList($request);

    public function getBettingHistory($request);

    public function getWinningList($request);

    public function getWinningNumberList($request);
}
