<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;

class EventTicketTypeController extends Controller
{
    public function __invoke(Event $event)
    {
        $ticketTypes = $event->ticket_types;

        if(request()->query('select') === 'available') {
            return response()->json(['data' => $ticketTypes->filter->isOpen]);
        }

        return response()->json([ 'data' => $ticketTypes ]);
    }
}
