<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Notifications\CompleteTicketsReminder as NotificationsCompleteTicketsReminder;
use Illuminate\Console\Command;

class CompleteTicketsReminder extends Command
{
    protected $signature = 'app:complete-tickets-reminder';

    protected $description = 'Send reminder emails to folks with incomplete tickets';

    public function handle(): void
    {
        $this->info('Running reminder emails to orders with incomplete tickets...');

        $orders = Order::query()
            ->whereHas('tickets', function ($query) {
                $query->whereNull('user_id');
            })
            ->whereHas('event', function ($query) {
                $query->where('start', '>', now());
            })
            ->with('user')
            ->get();

        $this->info($orders->count() . ' reminders need to be sent.');

        $this->info('Sending notifications...');

        $orders->each(function ($order) {
            $order->user->notify(new NotificationsCompleteTicketsReminder($order));
        });

        $this->info('Complete Tickets Reminder Complete');
    }
}
