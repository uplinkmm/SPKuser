<?php
namespace App\Traits;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\GameSetting;

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

        $gameSettingQuery = GameSetting::where('id', $gameSettingId);

        switch ($game->type) {
            case '2d':
                $gameSettingQuery->whereTime('opening_time', '<=', $currentTime)
                    ->whereTime('closing_time', '>=', $currentTime);
                break;
            case '3d':
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
}