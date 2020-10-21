<?php

namespace App\Console;

use App\Console\Commands\GetDataSnapshot;
use App\Console\Commands\ImportWaitsForCommand;
use App\Console\Commands\ReduceSnapshotData;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        GetDataSnapshot::class,
        ImportWaitsForCommand::class,
        ReduceSnapshotData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('get:data-snapshot')->everyMinute()->withoutOverlapping(5);
        $schedule->command('reduce-data')->everyFifteenMinutes()->withoutOverlapping(60);
        $schedule->command('telescope:prune')->hourly();
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
