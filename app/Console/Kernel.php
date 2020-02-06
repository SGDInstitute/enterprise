<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('emails:payment mblgtacc-2020')->weekly()->mondays()->at('13:00')->timezone('America/New_York');
        $schedule->command('emails:fill mblgtacc-2020')->weekly()->tuesdays()->at('13:00')->timezone('America/New_York');
        $schedule->command('clean:directories')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
