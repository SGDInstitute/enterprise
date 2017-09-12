<?php

namespace App\Http\Controllers;

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

        $invoice->name = array_get($data, 'name');
        $invoice->email = array_get($data, 'email');
        $invoice->address = array_get($data, 'address');
        $invoice->address_2 = array_get($data, 'address_2');
        $invoice->city = array_get($data, 'city');
        $invoice->state = array_get($data, 'state');
        $invoice->zip = array_get($data, 'zip');

        $invoice->save();

        Mail::to($invoice->order->user->email)->cc($invoice->email)->send(new InvoiceEmail($invoice->order));
    }
}
