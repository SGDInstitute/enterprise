<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Http\Controllers\Controller;

class OrderTicketsController extends Controller
{
    public function store(Order $order) {
        $order->tickets()->create(['ticket_type_id' => request('ticket_type_id')]);
    }
}
