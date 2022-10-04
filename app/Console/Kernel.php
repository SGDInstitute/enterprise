<?php

namespace App\Console;

use App\Jobs\RemoveStalePaymentIntents;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('media-library:delete-old-temporary-uploads')->daily();

        $schedule->job(new RemoveStalePaymentIntents)->hourly();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
