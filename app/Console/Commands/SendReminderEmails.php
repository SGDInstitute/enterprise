<?php

namespace App\Console\Commands;

use App\Event;
use App\Notifications\PaymentReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendReminderEmails extends Command
{

    protected $signature = 'emails:payment {event}';

    protected $description = 'Payment Reminder Email';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $event = Event::whereSlug($this->argument('event'))->with('orders.user')->first();

        if ($event->start >= now()) {
            $sevenDaysAgo = Carbon::parse('-7 days');

            $event->orders
                ->filter(function ($order) use ($sevenDaysAgo) {
                    return $order->confirmation_number === null && $order->created_at <= $sevenDaysAgo;
                })
                ->each(function ($order) {
                    $order->user->notify(new PaymentReminder($order));
                });
        }
    }
}
