<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class InvoicesDownloadController extends Controller
{
    public function index(Invoice $invoice)
    {
        return PDF::loadView('pdf.invoice', ['order' => $invoice->order])->download('invoice.pdf');
    }
}
