<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * In crontab * * * * * cd  /var/www/andon.3b.my && /usr/bin/php8.2 artisan schedule:run >> /dev/null 2>&1 
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:create-status')->everyFifteenMinutes();
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
