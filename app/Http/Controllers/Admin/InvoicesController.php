<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;

class InvoicesController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::find($id);

        if (is_null($invoice)) {
            flash("No invoice found with #$id")->error();
            return redirect()->back();
        }

        return redirect()->route('admin.orders.show', $invoice->order);
    }
}
