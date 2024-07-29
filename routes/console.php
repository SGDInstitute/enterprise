<?php

use App\Console\Commands\CompleteTicketsReminder;
use App\Models\EventBulletin;
use App\Notifications\BroadcastBulletin;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::call(function () {
    EventBulletin::with('event')->where('published_at', '<', now())->where('published_at', '>', now()->subMinutes(5))->where('notify', 1)->get()->each(function ($bulletin) {
        Notification::send($bulletin->event->paidAttendees()->unique(), new BroadcastBulletin($bulletin));
    });
})->everyFiveMinutes();

Schedule::command(PaymentReminder::class)->weeklyOn(Schedule::SUNDAY);
Schedule::command(CompleteTicketsReminder::class)->weeklyOn(Schedule::MONDAY);
Schedule::command(InvitationReminder::class)->weeklyOn(Schedule::TUESDAY);

Schedule::command(RunHealthChecksCommand::class)->everyMinute();
