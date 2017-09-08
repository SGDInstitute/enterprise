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
            $user = User::findByEmail($email);

            if (is_null($user)) {
                $user = User::create(['email' => $email, 'password' => str_random(50)]);
            }

            $ticket = Ticket::find(Hashids::decode($hash));

            $ticket->user_id = $user->id;

            Mail::to($user->email)->send(new InviteUserEmail($user));
        }
    }
}
