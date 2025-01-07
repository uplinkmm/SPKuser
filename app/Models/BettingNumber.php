<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingNumber extends Model
{
    use HasFactory;
    protected $fillable=['number','amount','bet_id','is_win','betting_multiplier','game_setting_id'];
}
