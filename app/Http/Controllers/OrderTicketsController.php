<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderTicketsController extends Controller
{
    public function edit(Order $order)
    {
        return view('tickets.edit', ['order' => $order, 'tickets' => $order->tickets]);
    }
}
