<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Livewire\Component;
use Stripe\PaymentIntent;

class Payment extends Component
{
    public Order $order;

    public $address = [
        'line1' => '',
        'line2' => '',
        'city' => '',
        'state' => '',
        'zip' => '',
        'country' => '',
    ];

    public function mount()
    {
        $this->startPayment();
    }

    public function render()
    {
        return view('livewire.app.orders.payment');
    }

    public function saveAddress()
    {
        $data = $this->validate([
            'address.line1' => ['required'],
            'address.line2' => ['nullable'],
            'address.city' => ['required'],
            'address.state' => ['required'],
            'address.zip' => ['required'],
            'address.country' => ['required'],
        ], [
            'address.line1.required' => 'Street address is required',
            'address.city.required' => 'City is required',
            'address.state.required' => 'State is required',
            'address.zip.required' => 'ZIP or Postal Code is required',
            'address.country.required' => 'Country is required',
        ]);

        auth()->user()->address = $data['address'];
        auth()->user()->save();
    }

    private function startPayment()
    {
        if ($this->order->transaction_id) {
            $paymentIntent = PaymentIntent::retrieve($this->order->transaction_id);
        } else {
            $paymentIntent = PaymentIntent::create([
                'amount' => 20000, // to-do calculate current cost for order
                'currency' => 'usd',
                'metadata' => [
                    'order' => $this->order->id,
                ],
            ]);

            $this->order->transaction_id = $paymentIntent->id;
            $this->order->save();
        }

        $this->clientSecret = $paymentIntent->client_secret;
    }
}
