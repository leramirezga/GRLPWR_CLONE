<?php

namespace App\Console;

use App\Jobs\CalculateActiveClients;
use App\Jobs\CheckClientPlansExpiration;
use App\Jobs\ClearAssistedAchievement;
use App\Utils\FeaturesEnum;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\ValidarKangoosReservados',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $featureState = DB::table('features')->where('title', FeaturesEnum::SEE_PLAN_EXPIRATION)->whereNotNull('active_at');
        if ($featureState) {
            $schedule->call(new CheckClientPlansExpiration())->dailyAt('09:00');
        }
        $schedule->call(new CalculateActiveClients())->dailyAt('01:00');
        $schedule->call(new ClearAssistedAchievement())->sundays()->at('23:59:59');
        $schedule->command("validator:kangosReservados")->everyMinute();
        //$schedule->command("validator:transaccionesPendientes")->cron("*/5 * * * *");
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
