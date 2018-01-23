<?php

namespace App\Http\Controllers;

use App\Ticket;

class TicketsUsersController extends Controller
{
    public function destroy($hash)
    {
        $ticket = Ticket::findByHash($hash);

        $ticket->user_id = null;
        $ticket->save();

        return response()->json($ticket, 200);
    }
}
