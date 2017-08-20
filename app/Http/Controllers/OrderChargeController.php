<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderChargeController extends Controller
{
    private $paymentGateway;

    public function __construct(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    public function store(Order $order)
    {
        $order->transaction_id = $this->paymentGateway->charge($order->amount, request('payment_token'));
        $order->transaction_date = Carbon::now();
        $order->save();
        return response()->json(['order' => $order], 201);
    }
}
