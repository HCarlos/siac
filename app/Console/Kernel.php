<?php

namespace App\Console;

use App\Console\Commands\ActualizaEstadisticasAROCommand;
use App\Console\Commands\RefreshStatusDenunciasCommand;
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
        RefreshStatusDenunciasCommand::class,
        ActualizaEstadisticasAROCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        // $schedule->command('inspire')
        //          ->hourly();

//        $schedule->command('backup:clean')->daily()->at('01:00');
//        $schedule->command('backup:run')->daily()->at('01:30');

        $schedule->command(RefreshStatusDenunciasCommand::class, ['--force'])->daily()->at('02:00');

        // Actualiza estadísticas ARO de Servicios Municipales — diario a las 03:00
        $schedule->command(ActualizaEstadisticasAROCommand::class)->daily()->at('03:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(){
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
