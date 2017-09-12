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
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => '',
            'address_2' => '',
            'city' => '',
            'state' => '',
            'zip' => ['nullable', 'numeric']
        ]);

        $order->invoice()->create([
            'name' => array_get($data, 'name'),
            'email' => array_get($data, 'email'),
            'address' => array_get($data, 'address'),
            'address_2' => array_get($data, 'address_2'),
            'city' => array_get($data, 'city'),
            'state' => array_get($data, 'state'),
            'zip' => array_get($data, 'zip'),
        ]);

        Mail::to($order->user->email)->send(new InvoiceEmail($order));

        return response([], 201);
    }
}
