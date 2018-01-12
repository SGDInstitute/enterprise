<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;

class OrdersController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['receipt', 'event', 'user', 'tickets.user'])->findOrFail($id);

        return view('admin.orders.show', [
            'order' => Order::with(['receipt', 'event', 'user', 'tickets.user'])->findOrFail($id),
        ]);
    }
}
