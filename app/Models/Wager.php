<?php

namespace App\Models;

use App\Enums\WagerStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wager extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'seamless_wager_id',
        'seamless_transaction_id',
        'status',
    ];

    protected $casts = [
        'status' => WagerStatus::class,
    ];

    public function transactions()
    {
        return $this->hasMany(SeamlessTransaction::class);
    }

    public function latestTransaction()
    {
        return $this->hasOne(SeamlessTransaction::class)->latestOfMany();
    }
}
