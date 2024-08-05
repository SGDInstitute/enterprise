<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasTicketForEvent
{
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('event');
        if ($event && get_class($event) === Event::class) {
            abort_if(! $request->user()->hasTicketFor($event), 403, "You must have a ticket for {$event->name} to view the message board.");
        }

        return $next($request);
    }
}
