<?php

namespace App\Models;

use Bavix\Wallet\Models\Wallet as WalletBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGameWallet extends WalletBase
{
    use HasFactory;
    protected $fillable=['customer_id','promotion_balance','game_balance','in_balance','out_balance','balance'];
}
