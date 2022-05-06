<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderReceipt;
use Stripe\PaymentIntent;

class OrdersProcessController extends Controller
{
    public function __invoke()
    {
        $paymentIntent = PaymentIntent::retrieve(request('payment_intent'));

        $order = Order::firstWhere('transaction_id', $paymentIntent->id);

        $order->update([
            'status' => $paymentIntent->status,
            'amount' => $paymentIntent->amount_received,
            'paid_at' => $paymentIntent->status === 'succeeded' ? now() : null,
        ]);

        $order->user->notify(new OrderReceipt($order));

        return redirect()->route('app.orders.show', ['order' => $order, 'thank-you' => true]);
    }
}
