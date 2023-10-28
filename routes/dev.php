<?php

use App\Models\Order;
use App\Notifications\CompleteTicketsReminder;
use App\Notifications\PaymentReminder;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->group(function () {
    Route::get('payment-reminder', function () {
        $order = Order::reservations()->where('event_id', 9)->first();

        return (new PaymentReminder($order))
                    ->toMail($order->user);
    });

    Route::get('complete-tickets-reminder/{order?}', function (Order $order) {
        if ($order->id === null) {
            $order = Order::query()
                ->whereHas('tickets', function ($query) {
                    $query->whereNull('user_id');
                })
                ->whereHas('event', function ($query) {
                    $query->where('start', '>', now());
                })
                ->with('user')
                ->first();
        }

        return (new CompleteTicketsReminder($order))
                    ->toMail($order->user);
    });
});
