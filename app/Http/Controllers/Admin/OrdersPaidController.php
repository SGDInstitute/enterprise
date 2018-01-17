<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptEmail;

class OrdersPaidController extends Controller
{
    public function update(Order $order)
    {
        $data = request()->validate([
            'check_number' => 'required_if:comped,false',
            'amount' => 'required_if:comped,false',
        ]);

        if (request('comped')) {
            $order->markAsPaid(collect([
                'id' => 'comped',
                'amount' => 0,
            ]));
        } else {
            $order->markAsPaid(collect([
                'id' => str_start($data['check_number'], '#'),
                'amount' => $data['amount'],
            ]));
        }

        Mail::to($order->user->email)->send(new ReceiptEmail($order->fresh()));
    }
}
