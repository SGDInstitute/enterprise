<?php

use App\Models\Order;
use App\Notifications\PaymentReminder;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->group(function () {
    Route::get('payment-reminder', function () {
        $order = Order::reservations()->where('event_id', 9)->first();

        return (new PaymentReminder($order))
                    ->toMail($order->user);
    });
});
