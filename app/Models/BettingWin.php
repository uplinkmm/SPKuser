<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingWin extends Model
{
    use HasFactory;
    protected $fillable=['number','date_time','time_status'];
}
