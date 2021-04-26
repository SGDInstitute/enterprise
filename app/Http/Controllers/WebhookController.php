<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleCheckoutSessionCompleted($payload)
    {
        $orderId = $payload['data']['object']['metadata']['order_id'];
        $order = Order::find($orderId);
        $order->transaction_id = $payload['data']['object']['payment_intent'];
        $order->reservation_ends = null;
        $order->paid_at = now();
        $order->confirmation_number = substr(str_shuffle(str_repeat('ABCDEFGHJKLMNPQRSTUVWXYZ23456789', 20)), 0, 20);
        $order->amount = $payload['data']['object']['amount_total'];
        $order->save();
    }
}
