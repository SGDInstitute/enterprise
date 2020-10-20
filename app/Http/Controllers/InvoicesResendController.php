<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Mail\InvoiceEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoicesResendController extends Controller
{
    public function index(Invoice $invoice)
    {
        Mail::to($invoice->order->user->email)->cc($invoice->email)->send(new InvoiceEmail($invoice->order));
    }
}
