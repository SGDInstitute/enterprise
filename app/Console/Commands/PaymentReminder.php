<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Notifications\PaymentReminder as NotificationsPaymentReminder;
use Illuminate\Console\Command;

class PaymentReminder extends Command
{
    protected $signature = 'app:payment-reminder';

    protected $description = 'Send reminder emails to folks with unpaid orders';

    public function handle(): void
    {
        $this->info('Running reminder emails to unpaid orders...');

        $orders = Order::query()
            ->whereHas('event', function ($query) {
                $query->where('start', '>', now());
            })
            ->reservations()
            ->with('user')
            ->get();

        $this->info($orders->count() . ' reminders need to be sent.');

        $this->info('Sending notifications...');

        $orders->each(function ($order) {
            $order->user->notify(new NotificationsPaymentReminder($order));
        });

        $this->info('Payment Reminder Complete');
    }
}
