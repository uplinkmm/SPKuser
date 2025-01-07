<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotTransaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_id',
        'member_id',
        'product_id',
        'provider_id',
        'provider_line_id',
        'wager_id',
        'currency_id',
        'game_type',
        'game_id',
        'game_round_id',
        'bet_amount',
        'payout_amount',
        'transaction_amount',
        'transaction_id',
        'commission_amount',
        'jackpot_amount',
        'settlement_date',
        'status',
        'modify_at',
    ];
}
