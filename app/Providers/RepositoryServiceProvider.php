<?php

namespace App\Providers;

use App\Repositories\Ads\AdsInterface;
use App\Repositories\Ads\AdsRepository;
use Illuminate\Support\ServiceProvider;

use Dotenv\Repository\RepositoryInterface;
use App\Repositories\Betting\BettingInterface;

use App\Repositories\Profile\ProfileInterface;
use App\Repositories\Betting\BettingRepository;
use App\Repositories\BettingTransaction\BettingTransactionInterface;
use App\Repositories\BettingTransaction\BettingTransactionRepository;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Notification\NotificationInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\CustomerMoney\CustomerMoneyRepository;
use App\Repositories\TopupTransaction\TopupTransactionRepository;
use App\Repositories\CustomerMoney\CustomerMoneyRepositoryInterface;
use App\Repositories\TopupTransaction\TopupTransactionRepositoryInterface;
use App\Repositories\CashWithdrawlTransaction\CashWithdrawlTransactionRepository;
use App\Repositories\CashWithdrawlTransaction\CashWithdrawlTransactionRepositoryInterface;
use App\Repositories\Seamless\SeamlessInterface;
use App\Repositories\Seamless\SeamlessRepository;
use App\Repositories\WalletTransfer\WalletTransferInterface;
use App\Repositories\WalletTransfer\WalletTransferRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->app->bind(CustomerMoneyRepositoryInterface::class, CustomerMoneyRepository::class);
        $this->app->bind(TopupTransactionRepositoryInterface::class, TopupTransactionRepository::class);
        $this->app->bind(CashWithdrawlTransactionRepositoryInterface::class, CashWithdrawlTransactionRepository::class);
        $this->app->bind(BettingInterface::class, BettingRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
        $this->app->bind(AdsInterface::class, AdsRepository::class);
        $this->app->bind(SeamlessInterface::class, SeamlessRepository::class);
        $this->app->bind(WalletTransferInterface::class, WalletTransferRepository::class);
        $this->app->bind(BettingTransactionInterface::class, BettingTransactionRepository::class);

    }
}
