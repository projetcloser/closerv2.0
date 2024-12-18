<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Enregistrement des commandes.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }

    /**
     * Définition des tâches planifiées.
     */
    protected function schedule(Schedule $schedule)
    {
        // planification de la verication annuel des cotisations de chaque utulisateur
        $schedule->call('App\Http\Controllers\CotisationController@verifierCotisationAnnuelle')
                 ->yearlyOn(1, 1, '00:00');
    }
}
