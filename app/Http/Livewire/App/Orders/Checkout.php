<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Livewire\Component;

class Checkout extends Component
{
    public Order $order;

    public function render()
    {
        return view('livewire.app.orders.checkout')
            ->with([
                'checkout' => $this->checkout,
            ]);
    }

    public function getCheckoutProperty()
    {
        return auth()->user()->checkout($this->order->ticketsFormattedForCheckout(), [
            'success_url' => route('app.orders.show', ['order' => $this->order, 'success']),
            'cancel_url' => route('app.orders.show', ['order' => $this->order, 'canceled']),
            'billing_address_collection' => 'required',
            'metadata' => [
                'order_id' => $this->order->id,
                'event_id' => $this->order->event->id,
            ]
        ]);
    }
}
