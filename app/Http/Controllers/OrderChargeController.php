<?php

namespace App\Http\Controllers;

use App\Billing\PaymentGateway;
use App\Exceptions\PaymentFailedException;
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
        try {
            $this->paymentGateway->setApiKey($order->event->getSecretKey());
            $order->markAsPaid($this->paymentGateway->charge($order->amount, request('stripeToken'))->id);

            flash('You successfully paid for this order, you will receive a confirmation email with a receipt shortly.')->success();
            return response()->json([
                'created' => true,
                'order' => $order
            ], 201);
        }
        catch (PaymentFailedException $e) {
            return response()->json([
                'created' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

    }
}
