<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceEmail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
            'zip' => ['nullable', 'numeric'],
        ]);

        $order->invoice()->create([
            'name' => Arr::get($data, 'name'),
            'email' => Arr::get($data, 'email'),
            'address' => Arr::get($data, 'address'),
            'address_2' => Arr::get($data, 'address_2'),
            'city' => Arr::get($data, 'city'),
            'state' => Arr::get($data, 'state'),
            'zip' => Arr::get($data, 'zip'),
        ]);

        Mail::to($order->user->email)->send(new InvoiceEmail($order));

        return response([], 201);
    }
}
