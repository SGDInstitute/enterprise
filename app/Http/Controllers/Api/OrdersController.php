<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function show($number)
    {
        if (is_numeric($number)) {
            return \App\Order::find($number)->load(['tickets.user.profile', 'receipt']);
        } else {
            $number = str_replace(['_', '-'], '', $number);
            return \App\Order::where('confirmation_number', $number)->with(['tickets.user.profile', 'receipt'])->firstOrFail();
        }
    }
}
