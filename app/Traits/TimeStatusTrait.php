<?php

namespace App\Traits;

use Carbon\Carbon;

trait TimeStatusTrait
{
    public function getTimeStatus()
    {
        $now = Carbon::now();
        $morning_start = $now->copy()->setTime(0, 0, 0);
        $morning_end = $now->copy()->setTime(12, 0, 0);
        $afternoon_start = $now->copy()->setTime(12, 1, 0);
        $afternoon_end = $now->copy()->setTime(16, 30, 0);

        if ($now->between($morning_start, $morning_end)) {
            return 'morning';
        } elseif ($now->between($afternoon_start, $afternoon_end)) {
            return 'evening';
        } else {
            return 'evening';
        }
    }
}
