<?php

namespace App\Providers;

use App\Models\Betting;
use App\Models\Customer;
use App\Models\WalletTransaction;
use App\Observers\BettingObserver;
use App\Observers\CustomerObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\WalletTransactionObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // RateLimiter::for('api', function ($request) {
        //     // Limit to 60 requests per minute per IP
        //     return Limit::perMinute(60)->by($request->ip());
        // });

        WalletTransaction::observe(WalletTransactionObserver::class);
        Betting::observe(BettingObserver::class);
        Customer::observe(CustomerObserver::class);
        Relation::enforceMorphMap([
            'customer' => 'App\Models\Customer',
            'betting' => 'App\Models\Betting',
            'betting_number' => 'App\Models\BettingNumber',
            'user' => 'App\Models\User',
            'topup_transaction' => 'App\Models\TopupTransaction',
            'cash_withdrawl_transaction' => 'App\Models\CashWithdrawlTransaction',
            'slot_transaction' => 'App\Models\SlotTransaction',
            'wallet' => 'App\Models\Wallet',
            'wallet_transfer' => 'App\Models\WalletTransfer',
        ]);
    }
}
