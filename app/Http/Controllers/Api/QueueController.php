<?php

namespace App\Http\Controllers\Api;

use App\Queue;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QueueController extends Controller
{
    public function store($ids)
    {
        Ticket::findByIds(explode(',', $ids))->load(['user.profile', 'order.receipt'])
            ->each(function ($ticket) {
                Queue::create([
                    'name' => $ticket->user->name,
                    'pronouns' => $ticket->user->profile->pronouns,
                    'tshirt' => $ticket->user->profile->tshirt,
                    'order_created' => $ticket->order->created_at,
                    'order_paid' => optional($ticket->order->receipt)->created_at,
                ]);
            });

        return response()->json([], 201);
    }
}
