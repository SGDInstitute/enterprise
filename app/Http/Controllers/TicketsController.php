<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function update($hash)
    {
        $ticket = Ticket::findByHash($hash);

        if (request()->has('user_id')) {
            $ticket->user_id = request('user_id');
            $ticket->save();
        }
        else {
            $ticket->fillManually(request()->all());
        }
    }
}
