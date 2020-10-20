<?php

namespace App\Http\Controllers;

use App\Mail\ReceiptEmail;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReceiptsResendController extends Controller
{
    public function index(Receipt $receipt)
    {
        Mail::to($receipt->order->user->email)->send(new ReceiptEmail($receipt->order));
    }
}
