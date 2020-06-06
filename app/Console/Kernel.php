<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\DeviceResetMessage;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\TurnOffEngine::class,
        \App\Console\Commands\CleanupDailyData::class,
        \App\Console\Commands\checkTaxDateExpired::class,
        \App\Console\Commands\checkFitnessDateExpired::class,
        \App\Console\Commands\DeviceResetMessage::class,
        \App\Console\Commands\DailySummerySmsGenerate::class,

        // Demo User purpose
        \App\Console\Commands\UpdateDemoCarEngine::class,
        \App\Console\Commands\CalculatePerformance::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('engine:off 300')->cron('*/5 * * * * *');
        $schedule->command('taxDate:expiration')->dailyAt('24:00');
        $schedule->command('fitnessDate:expiration')->dailyAt('24:00');
        $schedule->command('sms:summery')->dailyAt('09:00');
        $schedule->command('device:reset')->dailyAt('12:00');
        $schedule->command('queue:flush')->dailyAt('04:00');

        $schedule->command('demo:engine')->cron('*/3 * * * * *');
        $schedule->command('calc:performance')->dailyAt('4:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
