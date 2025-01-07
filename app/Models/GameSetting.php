<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameSetting extends Model
{
    use HasFactory;
    protected $fillable=['opening_time','closing_time','lottery_time','bet_multiplier','closing_amount','time_status','twist','game_id','is_active'];

    public function scopeCurrentTimeBetween($query)
    {
        $now = Carbon::now();
        return $query->where('opening_date_time', '<=', $now)
                     ->where('closing_date_time', '>=', $now);
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }
}
