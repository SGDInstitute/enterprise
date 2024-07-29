<?php

use App\Console\Commands\CompleteTicketsReminder;
use App\Console\Commands\InvitationReminder;
use App\Console\Commands\PaymentReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('horizon:snapshot')->everyFiveMinutes();

// Schedule::call(function () {
//     EventBulletin::with('event')->where('published_at', '<', now())->where('published_at', '>', now()->subMinutes(5))->where('notify', 1)->get()->each(function ($bulletin) {
//         Notification::send($bulletin->event->paidAttendees()->unique(), new BroadcastBulletin($bulletin));
//     });
// })->everyFiveMinutes();

Artisan::command(PaymentReminder::class)->weeklyOn(Schedule::SUNDAY);
Artisan::command(CompleteTicketsReminder::class)->weeklyOn(Schedule::MONDAY);
Artisan::command(InvitationReminder::class)->weeklyOn(Schedule::TUESDAY);

Artisan::command(RunHealthChecksCommand::class)->everyMinute();
