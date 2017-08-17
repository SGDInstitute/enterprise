<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['event', 'tickets'])->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}
