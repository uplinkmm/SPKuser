<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\BettingWin;
use App\Models\GameSetting;
use Illuminate\Http\Request;
use App\Http\Action\GameClosing;
use App\Http\Controllers\Controller;


class GameController extends Controller
{
    use GameClosing;
    public function index(Request $request)
    {
        $current_time = Carbon::now()->format('H:i:s');
        $game = Game::with([
            'twodSettings' => function ($q) use ($current_time) {
                $q
                    ->where('is_active', 1)
                    ->where('opening_time', '<=', $current_time)
                    ->where('closing_time', '>=', $current_time);
            }
        ])
            ->find($request->game_id);
        if ($game) {
            $currentTime = Carbon::now();
            $day = Carbon::now()->day;
            $now = Carbon::now();
            if ($day >= 1 && $day <= 15) {
                // $date= i want to define current data ,current month and day is 1
                $date = Carbon::now()->setDate(Carbon::now()->year, Carbon::now()->month, 16);
            }
            if ($day > 15) {
                // $date= i want to define current data ,current month and day is 16
                $date = Carbon::now()->setDate(Carbon::now()->year, Carbon::now()->addMonth()->month, 1);
            }
            $date = convertDateFormat($date);
            $game_setting = GameSetting::where('game_id', $request->game_id)
                // ->when($game->type == '3d', function ($query) use ($date) {
                //     $query->whereDate('lottery_date_time', $date);
                // })
                ->when($game->type == '3d', function ($query) use ($now) {
                    $query->where('opening_date_time', '<=', $now)
                        ->where('closing_date_time', '>=', $now);
                })
                ->orderBy('id', 'desc');
            if ($game->type == '2d') {
                // if ($currentTime->isSaturday() || $currentTime->isSunday()) {
                //     $game->settings = [];
                // }else{
                //     $game->settings = $game_setting->get();
                // }
                $game->settings = $game_setting->get();
            }
            if ($game->type == '3d') {
                // dd($game_setting->get());
                $gameSetting = $game_setting->first();
                if ($gameSetting) {
                    // dd($gameSetting);
                    $game->settings = collect([$gameSetting]);
                } else {
                    $game->settings = [];
                }
            }
            if ($game) {
                if ($game->type == '3d') {
                    $getPreviousWinningNumber = $this->getPreviousWinningNumber($game->id);
                    $game->winning_numbers = $getPreviousWinningNumber;
                }
                ResponseData($game);
            }
        }

        ResponseMessage('Game Not Found', 404);
    }
    public function getPreviousWinningNumber($gameId)
    {
        $winningNumber = BettingWin::join('game_settings', 'betting_wins.game_setting_id', 'game_settings.id')
            ->join('games', 'game_settings.game_id', 'games.id')
            ->where('games.id', $gameId)
            ->where('betting_wins.date_time', '>=', Carbon::now()->subMonths(6)) // Filter for the last 6 months
            ->where('betting_wins.is_approved', 1)
            ->select('betting_wins.id', 'number', 'game_settings.lottery_date_time', 'game_settings.lottery_time', 'games.type')
            ->orderBy('betting_wins.id', 'desc')
            ->get();
        return $winningNumber;
    }

    public function getGameSetting(Request $request)
    {

    }
}
