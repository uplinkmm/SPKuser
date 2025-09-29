<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\BettingWin;
use App\Models\GameSetting;
use App\Models\LotteryNumber;
use App\Models\LotteryWinningNumber;

trait BettingValidation
{
    public function checkValidTimeByGameSetting($gameId, $gameSettingId)
    {
        $currentDateTime = Carbon::now();
        $currentTime = $currentDateTime->format('H:i');
        $game = Game::where('is_active', 1)->where('id', $gameId)
            ->first();
        if (!$game) {
            ResponseMessage('Game is invalid ', 419);
        }
        $this->checkGameAlreadyResult($gameSettingId, $game->type); // check  already result 
        // $gameSetting=GameSetting::find($gameSettingId);
        // $gameSetting = null;
        // if ($game->type == '2d') {
        //     $currentTime = Carbon::now()->format('H:i');
        //     $gameSetting = GameSetting::where('id', $gameSettingId)
        //         ->whereTime('opening_time', '<=', $currentTime)
        //         ->whereTime('closing_time', '>=', $currentTime)
        //         ->first();
        // }
        // if ($game->type == '3d') {
        //     $currentDateTime = Carbon::now();
        //     $gameSetting = GameSetting::where('id', $gameSettingId)
        //         ->where('opening_date_time', '<=', $currentDateTime)
        //         ->where('closing_date_time', '>=', $currentDateTime)
        //         ->first();
        // }

        $gameSettingQuery = GameSetting::where('id', $gameSettingId)->where('is_active', 1);
        switch ($game->type) {
            case '2d':
                $gameSettingQuery->whereTime('opening_time', '<=', $currentTime)
                    ->whereTime('closing_time', '>=', $currentTime);
                break;
            case '3d':
                $gameSettingQuery->where('opening_date_time', '<=', $currentDateTime)
                    ->where('closing_date_time', '>=', $currentDateTime);
                break;
            case 'draw':
                $gameSettingQuery->where('opening_date_time', '<=', $currentDateTime)
                    ->where('closing_date_time', '>=', $currentDateTime);
                break;
            default:
                return ResponseMessage('Invalid game type', 419);
        }

        $gameSetting = $gameSettingQuery->first();

        if (!$gameSetting) {
            ResponseMessage('Game Setting is invalid', 419);
        }
    }
    public function checkLotteryNumberExist($gameSettingId, $number)
    {
        $lotteryNumber = LotteryNumber::join('lotteries', 'lottery_numbers.lottery_id', 'lotteries.id')
            ->where('number', $number)
            ->where('lotteries.game_setting_id', $gameSettingId)
            ->exists();
        if ($lotteryNumber) {
            ResponseMessage('Lottery number is invalid,choose other number', 419);
        }
        return true;
    }

    public function checkGameAlreadyResult($gameSettingId, $gameType)
    {
        $result = null;
        if ($gameType == '2d') {
            $today = Carbon::today();
            $result = BettingWin::where('game_setting_id', $gameSettingId)
                ->whereDate('date_time', $today)
                ->first();
        } elseif ($gameType == '3d') {
            $result = BettingWin::where('game_setting_id', $gameSettingId)->first();
        } elseif ($gameType == 'draw') {
            $result = LotteryWinningNumber::whereHas('prize', function ($q) use ($gameSettingId) {
                $q->where('game_setting_id', $gameSettingId);
            })->first();
        }
        if ($result) {
            ResponseMessage('Betting is invalid, Game result already exists', 419);
        }
        return true;
    }
}