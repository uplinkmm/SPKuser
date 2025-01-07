<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable=['name','phone_number','account_type','deposit_id','withdrawal_id','is_active'];
    protected $with=['deposit','withdrawal'];
    public function deposit(){
        return $this->belongsTo(TransactionType::class,'deposit_id')->select('id','name','min','max','is_active');
    }

    public function withdrawal(){
        return $this->belongsTo(TransactionType::class,'withdrawal_id')->select('id','name','min','max','is_active');
    }
}
