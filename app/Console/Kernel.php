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
        logger('schedul run sucess every minute');
        $schedule->command('queue:work --stop-when-empty')->everyMinute();
        $schedule->command('queue:restart')->everyFiveMinutes();
        $schedule->command('send-reminders')->dailyAt('9:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
