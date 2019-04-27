<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Invoice;
use App\Mail\InvoiceEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoicesController extends Controller
{
    public function show(Invoice $invoice)
    {
        $order = $invoice->order;

        if (request()->ajax()) {
            return ['invoice' => view('pdf.invoice', compact('order'))->render()];
        }

        return view('pdf.invoice', compact('order'));
    }

    public function update(Invoice $invoice)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => '',
            'address_2' => '',
            'city' => '',
            'state' => '',
            'zip' => ['nullable', 'numeric'],
        ]);

        $invoice->name = Arr::get($data, 'name');
        $invoice->email = Arr::get($data, 'email');
        $invoice->address = Arr::get($data, 'address');
        $invoice->address_2 = Arr::get($data, 'address_2');
        $invoice->city = Arr::get($data, 'city');
        $invoice->state = Arr::get($data, 'state');
        $invoice->zip = Arr::get($data, 'zip');

        $invoice->save();

        Mail::to($invoice->order->user->email)->cc($invoice->email)->send(new InvoiceEmail($invoice->order));
    }
}
