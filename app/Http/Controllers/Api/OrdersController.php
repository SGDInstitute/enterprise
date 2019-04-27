<?php

namespace App\Http\Controllers\Api;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function show($number)
    {
        if (is_numeric($number)) {
            $order = Order::find($number)->load(['tickets.user.profile', 'receipt']);
        } else {
            $number = str_replace(['_', '-'], '', $number);
            $order = Order::where('confirmation_number', $number)->with(['tickets.user.profile', 'receipt'])->firstOrFail();
        }

        $order->amount = $order->amount;

        return $order;
    }
}