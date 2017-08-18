<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['event', 'tickets'])->findOrFail($id);

        $this->authorize('view', $order);

        return view('orders.show', compact('order'));
    }
}
