<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\PaymentReminder;
use App\Notifications\ScheduledTask;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendFillReminderEmails extends Command
{
    protected $signature = 'emails:fill {event}';

    protected $description = 'Fill Reminder Email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $event = Event::whereSlug($this->argument('event'))->with('orders.user', 'orders.tickets')->first();

        if ($event->start >= now()) {
            $sevenDaysAgo = Carbon::parse('-7 days');

            $event->orders
                ->filter(function ($order) use ($sevenDaysAgo) {
                    return $order->tickets()->filled()->count() < $order->tickets->count() && $order->created_at <= $sevenDaysAgo;
                })
                ->each(function ($order) {
                    $order->user->notify(new PaymentReminder($order));
                });

            User::find(1)->notify(new ScheduledTask("Fill Reminder Emails for {$event->title} have been sent."));
        }
    }
}
