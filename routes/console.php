<?php

use App\Console\Commands\CompleteTicketsReminder;
use App\Console\Commands\InvitationReminder;
use App\Console\Commands\PaymentReminder;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;

// // Schedule::call(function () {
// //     EventBulletin::with('event')->where('published_at', '<', now())->where('published_at', '>', now()->subMinutes(5))->where('notify', 1)->get()->each(function ($bulletin) {
// //         Notification::send($bulletin->event->paidAttendees()->unique(), new BroadcastBulletin($bulletin));
// //     });
// // })->everyFiveMinutes();

Schedule::command('horizon:snapshot')->everyFiveMinutes();

Schedule::command(PaymentReminder::class)->sundays();
Schedule::command(CompleteTicketsReminder::class)->mondays();
Schedule::command(InvitationReminder::class)->tuesdays();

Schedule::command(RunHealthChecksCommand::class)->everyMinute();
