<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

     protected $commands = [
        'App\Console\Commands\Callapi'
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('call:api')
        ->onSuccess(function () {
            Log::info('call:api command status is success');
        })
        ->onFailure(function () {
            Log::info('call:api command status is fail');
        });

        // $schedule->command('send:messages')
        // ->everyFifteenMinutes();

        // $schedule->command('send:image')
        // ->everyFifteenMinutes();

        // $schedule->command('reminder:message')
        // ->daily();
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
