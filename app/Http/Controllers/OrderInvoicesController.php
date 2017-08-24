<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceEmail;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderInvoicesController extends Controller
{
    public function store(Order $order)
    {
        $order->invoice()->create([
            'address' => request()->address,
            'address_2' => request()->address_2,
            'city' => request()->city,
            'state' => request()->state,
            'zip' => request()->zip,
        ]);

        Mail::to($order->user->email)->send(new InvoiceEmail($order));

        return response([], 201);
    }
}
