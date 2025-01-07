<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['amount','date_time','walletable_type','walletable_id','action','customer_id'];
}
