<?php

namespace App\Actions;

use App\Models\Order;
use App\Notifications\OrderCreatedForPresentation;

class GeneratePresenterOrderForEvent
{
    public function __invoke($event, $proposal, $user)
    {
        $order = Order::create(['event_id' => $event->id, 'user_id' => $user->id]);
        $order->tickets()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_type_id' => $event->ticketTypes->first()->id,
            'price_id' => $event->ticketTypes->first()->prices->first()->id,
        ]);

        $order->markAsPaid("comped-workshop-{$proposal->id}", 0);

        $user->notify(new OrderCreatedForPresentation($order, $proposal));
    }
}
