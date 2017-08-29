<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

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
}
