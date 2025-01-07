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
    ];

    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class);
    // }

    public function holderable(): MorphTo
    {
        return $this->morphTo();
    }
}
