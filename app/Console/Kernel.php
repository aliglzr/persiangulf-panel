<?php

namespace App\Console;

use App\Jobs\CheckSubscriptions;
use App\Jobs\CreateTrafficUsage;
use App\Jobs\Payments\RejectUnpaidPayments;
use App\Jobs\SendSubscriptionNotification;
use App\Jobs\Servers\GetLoadAttribute;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void {
        if (true){
            if (config('services.backup.take_backup_in_schedule')){
                $schedule->command('backup:clean')->dailyAt(config('services.backup.clean_backup_daily_at'));
                $schedule->command('backup:run')->dailyAt(config('services.backup.take_backup_daily_at'));
            }
            $schedule->job(new RejectUnpaidPayments())->everyMinute();
            $schedule->job(new CheckSubscriptions())->everyMinute();
            $schedule->job(new SendSubscriptionNotification())->everyMinute();
            $schedule->call(function (){
                CreateTrafficUsage::dispatch()->onConnection('redis')->onQueue('traffic');
            })->everyFiveMinutes();
//            $schedule->call(function (){
//                GetLoadAttribute::dispatch()->onConnection('redis')->onQueue('default');
//            })->everyMinute();
            $schedule->call(function (){
                DatabaseNotification::where('created_at','<',now()->subMonth())->delete();
            })->daily();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
