<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Queue;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class QueueController extends Controller
{
    public function index()
    {
        return Queue::where('completed', false)->get()->sortBy('created_at');
    }

    public function store($ids)
    {
        $tickets = Ticket::findByIds(explode(',', $ids))->load(['user.profile', 'order.receipt'])
            ->filter(function ($ticket) {
                // remove tickets that are in the queue
                return ! Queue::where('ticket_id', $ticket->id)->exists();
            });

        if ($tickets->count() > 0) {
            $batch = Hashids::encode($tickets->first()->order->id);

            $tickets->each(function ($ticket) use ($batch) {
                Queue::create([
                    'batch' => $batch,
                    'ticket_id' => $ticket->id,
                    'name' => $ticket->user->name,
                    'pronouns' => $ticket->user->profile->pronouns,
                    'college' => $ticket->user->profile->college,
                    'tshirt' => $ticket->user->profile->tshirt,
                    'order_created' => $ticket->order->created_at,
                    'order_paid' => optional($ticket->order->receipt)->created_at,
                ]);
            });
        }

        return response()->json([], 201);
    }
}
