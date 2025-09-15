<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lottery extends Model
{
    use HasFactory;
    protected $fillable = ['date_time', 'lottery_no_id', 'total_amount', 'customer_id', 'game_id','game_setting_id','lottery_promotion_id'];

    // public static function generateUniqueLotteryId()
    // {
    //     $timestamp = Carbon::now()->format('YmdHis'); // Add timestamp
    //     do {
    //         $randomString = Str::random(10); // Adjust the length as needed
    //         $lotteryNumber = $timestamp . $randomString;
    //     } while (self::where('lottery_no_id', $lotteryNumber)->exists());

    //     return $lotteryNumber;
    // }

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a formatted lottery number before creating the record
        static::creating(function ($bet): void {
            $bet->lottery_no_id = self::generateFormattedLotteryId();
        });
    }
    public static function generateFormattedLotteryId()
    {
        $timestamp = now()->format('YmdHis'); // Current timestamp
        $uuid = Uuid::uuid4()->toString(); // Generate UUID
        // Format the lottery number: "BET-{timestamp}-{UUID}"
        return "LOTTERY-{$timestamp}-{$uuid}";
    }

    public function lotteryNumbers(){
        return $this->hasMany(LotteryNumber::class);
    }
}
