<?php

namespace App\Http\Controllers;

use App\Mail\InviteUserEmail;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class OrderTicketsController extends Controller
{
    public function update(Order $order)
    {
        foreach (request('emails') as $hash => $email) {
            Ticket::find(Hashids::decode($hash))->first()->invite($email);
        }
    }
}
