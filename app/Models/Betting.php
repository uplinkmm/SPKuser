<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Game;
use Ramsey\Uuid\Uuid;
use App\Models\Customer;
use App\Models\GameSetting;
use Illuminate\Support\Str;
use App\Models\BettingNumber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Betting extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['date_time', 'betting_no_id', 'total_amount', 'customer_id', 'game_id','time_status','game_setting_id'];

    public static function generateUniqueBettingNumber()
    {
        $timestamp = Carbon::now()->format('YmdHis'); // Add timestamp
        do {
            $randomString = Str::random(10); // Adjust the length as needed
            $bettingNumber = $timestamp . $randomString;
        } while (self::where('betting_no_id', $bettingNumber)->exists());

        return $bettingNumber;
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a formatted betting number before creating the record
        static::creating(function ($bet) {
            $bet->betting_no_id = self::generateFormattedBettingNumber();
        });
    }
    /**
     * Generate a formatted betting number.
     *
     * @return string
     */
    public static function generateFormattedBettingNumber()
    {
        $timestamp = now()->format('YmdHis'); // Current timestamp
        $uuid = Uuid::uuid4()->toString(); // Generate UUID

        // Format the betting number: "BET-{timestamp}-{UUID}"
        return "BET-{$timestamp}-{$uuid}";
    }

    public function bettingNumbers(){
        return $this->hasMany(BettingNumber::class);
    }

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function gameSetting(){
        return $this->belongsTo(GameSetting::class);
    }
}
