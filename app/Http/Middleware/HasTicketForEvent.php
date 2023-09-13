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
        $event = Event::where('slug', $request->route('event'))->firstOrFail();

        abort_if(!$request->user()->hasTicketFor($event), 403, "You must have a ticket for {$event->name} to view the message board.");

        return $next($request);
    }
}
