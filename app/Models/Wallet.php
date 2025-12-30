<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Bavix\Wallet\Models\Wallet as WalletBase;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends WalletBase
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'walletId',
        'balance',
        'in_balance',
        'out_balance',
        'type',
        'name',
        'default',
        'slug',
        'decimal_places',
        'promotion_balance',
    ];

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }

    public function getPromotionBalanceFloatAttribute(): float
    {
        return $this->promotion_balance / (10 ** $this->decimal_places);
    }
    
    public function holderable(): MorphTo
    {
        return $this->morphTo();
    }
}
