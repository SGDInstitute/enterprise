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

        $order->markAsPaid($payload['data']['object']['payment_intent'], $payload['data']['object']['amount_total']);
    }
}
