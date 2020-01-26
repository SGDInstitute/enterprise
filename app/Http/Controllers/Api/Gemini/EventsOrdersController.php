<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class EventsOrdersController extends Controller
{
    public function index($id)
    {
        $orders = auth()->user()->orders()->where('event_id', $id)->get()
            ->merge(
                auth()->user()->tickets()->with('order')->upcoming()->get()
                    ->map(function ($ticket) {
                        return $ticket->order;
                    })
            )
            ->load('tickets.user.roles', 'tickets.user.profile', 'tickets.ticket_type', 'tickets.queue');

        return OrderResource::collection($orders);
    }
}
