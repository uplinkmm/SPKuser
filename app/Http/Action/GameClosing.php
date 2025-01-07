<?php
namespace App\Http\Action;

use Carbon\Carbon;
use App\Models\Game;

trait GameClosing{
    public function setClosingTime($game){
        // $games= Game::orderBy('id','asc')->where('name','2D')->get();
        $now = Carbon::now();
        // Define the time ranges and corresponding closing times
        $morning_start = $now->copy()->setTime(0, 0, 0);
        $morning_end = $now->copy()->setTime(12, 0, 0);
        $afternoon_start = $now->copy()->setTime(12, 1, 0);
        $afternoon_end = $now->copy()->setTime(16, 30, 0);
        // Determine the closing time based on the current time
        if ($now->between($morning_start, $morning_end)) {
            $time_status='morning';
            $bet_multiplier=85;
            $lottery_time=$now->copy()->setTime(12, 01, 0)->format('H:i');
            $opening_time = $now->copy()->setTime(00, 01, 0)->format('H:i');
            $closing_time = $now->copy()->setTime(11, 50, 0)->format('H:i');
        } elseif ( $now->between($afternoon_start, $afternoon_end)) {
            $time_status='evening';
            $bet_multiplier=90;
            $lottery_time=$now->copy()->setTime(16, 30, 0)->format('H:i');
            $opening_time = $now->copy()->setTime(12, 01, 0)->format('H:i');
            $closing_time = $now->copy()->setTime(15, 55, 0)->format('H:i');
        }elseif($now->isWeekend()){
            $closing_time = $now->copy()->setTime(0,0,0)->format('H:i');
            $lottery_time=null;
            $time_status='evening';
            $opening_time=$now->copy()->setTime(0, 0, 0)->format('H:i');
            $bet_multiplier=85;
        }
         else {
            $closing_time = $now->copy()->setTime(3, 55, 0)->format('H:i');
            $lottery_time=null;
            $time_status='evening';
            $opening_time=$now->copy()->setTime(12, 01, 0)->format('H:i');
            $bet_multiplier=90;
            // $closing_time = null;  // No closing time if outside the defined ranges
        }
        // $bet_multiplier=0;
        // $closing_time = $now->copy()->setTime(16, 30, 0)->format('H:i');
        // Update the game array with the closing time
        // if ($closing_time) {
            // foreach ($games as &$game) {
                $game->time_status=$time_status;
                $game->lottery_time=$lottery_time;
                $game->bet_multiplier=$bet_multiplier;
                $game->opening_time=$opening_time;
                $game->closing_time = $closing_time;
            // }
        // }
        return $game;
    }
}