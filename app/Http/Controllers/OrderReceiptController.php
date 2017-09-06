<?php

namespace App\Http\Controllers;

use App\Mail\OrderReceipt;
use App\Mail\ReceiptEmail;
use App\Order;
use Illuminate\Http\Request;

class OrderReceiptController extends Controller
{
    public function show(Order $order)
    {
        return new ReceiptEmail($order);
    }
}
