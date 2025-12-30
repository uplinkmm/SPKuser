<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromotion extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'start_date', 'end_date', 'amount', 'is_active'];
    public function customers()
    {
        return $this->morphToMany(Customer::class, 'promotion', 'customer_promotions');
    }
}
