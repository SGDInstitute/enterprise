<?php

namespace App\Http\Controllers;

use App\Mail\ReceiptEmail;
use App\Order;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{
    public function show(Order $order)
    {
        if (request()->ajax()) {
            return ['receipt' => (new ReceiptEmail($order))->render()];
        }

        return new ReceiptEmail($order);
    }
}
