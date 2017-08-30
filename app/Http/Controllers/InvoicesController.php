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
        $invoice->update(request()->all());

        Mail::to($invoice->order->user->email)->cc($invoice->email)->send(new InvoiceEmail($invoice->order));
    }
}
