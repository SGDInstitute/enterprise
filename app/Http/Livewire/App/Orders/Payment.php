<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Stripe\PaymentIntent;

class Payment extends Component
{
    public Order $order;

    public $address;

    public $name;

    public $email;

    public function mount()
    {
        $this->name = $this->order->invoice->name ?? auth()->user()->name;
        $this->email = $this->order->invoice->email ?? auth()->user()->email;
        $this->address = $this->order->invoice->address ?? [
            'line1' => '',
            'line2' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'country' => '',
        ];

        if ($this->order->isPaid()) {
            $this->transaction = $this->order->transactionDetails();
        } else {
            $this->startPayment();
        }
    }

    public function downloadInvoice()
    {
        if (! $this->order->invoice->created_at) {
            $this->order->invoice->created_at = now()->format('m/d/Y');
        }
        if (! $this->order->isPaid()) {
            $this->saveBillingInfo();
        }

        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $this->order->fresh(),
            'transaction' => $this->order->transactionDetails(),
        ])->output();

        $filename = ($this->order->isPaid() ? 'Receipt-' : 'Invoice-').$this->order->formattedId.'.pdf';

        return response()->streamDownload(fn () => print($pdf), $filename);
    }

    public function downloadW9()
    {
        return response()->download(public_path('documents/SGD-Institute-W9.pdf'));
    }

    public function saveBillingInfo()
    {
        $data = $this->validate([
            'name' => ['required'],
            'email' => ['required'],
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

        $this->order->invoice->set([
            'address' => $data['address'],
            'due_date' => $this->order->reservation_ends->format('m/d/Y'),
            'email' => $data['email'],
            'name' => $data['name'],
        ]);
        $this->order->save();
    }

    private function startPayment()
    {
        if ($this->order->transaction_id) {
            $paymentIntent = PaymentIntent::update(
                $this->order->transaction_id,
                ['amount' => $this->order->subtotalInCents]
            );
        } else {
            $paymentIntent = PaymentIntent::create([
                'amount' => $this->order->subtotalInCents,
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
