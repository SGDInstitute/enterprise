<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show($id)
    {
        return view('admin.orders.show', [
            'order' => Order::with(['receipt', 'event', 'user', 'tickets.user'])->findOrFail($id),
        ]);
    }
}
