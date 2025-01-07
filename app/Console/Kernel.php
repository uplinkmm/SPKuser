<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('store:winning-numbers')->everyMinute();
        $schedule->command('make:pull-report')->everyFiveSeconds();
        // $schedule->command('archive:old-wagers')->everyThirtyMinutes();
        // //$schedule->command('wagers:delete-old-backups')->everyThirtyMinutes();
        // $schedule->command('wagers:delete-old-backups')->cron('*/45 * * * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
