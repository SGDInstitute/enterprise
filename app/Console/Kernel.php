<?php

namespace App\Console;

use App\Models\EventBulletin;
use App\Notifications\BroadcastBulletin;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('horizon:snapshot')->everyFiveMinutes();

        $schedule->command('media-library:delete-old-temporary-uploads')->daily();

        $schedule->call(function () {
            EventBulletin::with('event')->where('published_at', '<', now())->where('published_at', '>', now()->subMinutes(5))->where('notify', 1)->get()->each(function ($bulletin) {
                Notification::send($bulletin->event->paidAttendees()->unique(), new BroadcastBulletin($bulletin));
            });
        })->everyFiveMinutes();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
