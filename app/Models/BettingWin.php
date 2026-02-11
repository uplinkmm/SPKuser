<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingWin extends Model
{
    use HasFactory;
    protected $fillable=['number','date_time','time_status'];
    // protected $appends = ['twist_csv'];

    // public function getTwistCsvAttribute()
    // {
    //     return $this->twist->pluck('number')->implode(',');
    // }

    public function twist(){
        return $this->hasMany(TwistWinNumber::class);
    }
}
