<?php

namespace App\Models;

use App\Models\User;
use App\Models\Customer;
use App\Models\SeamlessEvent;
use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeamlessTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_type_id',
        'product_id',
        'seamless_event_id',
        'game_code',
        'customer_id',
        'wager_id',
        'seamless_transaction_id',
        'rate',
        'transaction_amount',
        'bet_amount',
        'payout_amount',
        'valid_amount',
        'status',
        'action',
        'settled_at',
    ];

    protected $casts = [
        // 'status' => TransactionStatus::class,
    'settled_at' => 'datetime',
    ];                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function seamlessEvent()
    {
        return $this->belongsTo(SeamlessEvent::class, 'seamless_event_id');
    }

    public function transactions()
    {
        // return $this->hasMany(Transaction::class);
    }
}
