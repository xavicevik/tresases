<?php

namespace App\Console;

use App\Jobs\GestionCajasJob;
use App\Jobs\ValidarVentasJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('sessions:finish')->everyMinute();
        $schedule->command('cajas:openclose')->daily();
        $schedule->command('sessions:clearcheckout')->sundays();
        $schedule->command('ventas:processpayments')->everyTwoMinutes();
        //$schedule->job(new ValidarVentasJob())->everyTwoMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
