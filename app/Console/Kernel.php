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
        //$schedule->command('app:ejecutar-pago-recurrente')->daily()->at('00:00');
        /* O poner mejor en Crontab */
        /*
            0 0 * * * cd /var/www/controlgastos/ && php artisan app:ejecutar-pago-recurrente >> ~/ejecutar-pago-recurrente.log
        */

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
