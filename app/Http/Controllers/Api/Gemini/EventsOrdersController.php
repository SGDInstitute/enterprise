<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class EventsOrdersController extends Controller
{
    public function index($id)
    {
        $orders = auth()->user()->orders()->where('event_id', $id)->with('tickets.user', 'tickets.ticket_type', 'tickets.queue')->get();

        return OrderResource::collection($orders);
    }
}
