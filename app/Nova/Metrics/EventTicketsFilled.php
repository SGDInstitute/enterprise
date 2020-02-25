<?php

namespace App\Nova\Metrics;

use App\Event;
use App\Nova\Filters\Event as EventFilter;
use App\Ticket;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Nemrutco\Filterable\FilterablePartition;

class EventTicketsFilled extends Partition
{
    use FilterablePartition;

    public function filters()
    {
        return [new EventFilter];
    }

    public function calculate(NovaRequest $request)
    {
        if ($request->query(\App\Nova\Filters\Event::class)) {
            $event = Event::with('orders.tickets')->find($request->query(\App\Nova\Filters\Event::class));
            $tickets = $event->orders->flatMap(function ($order) {
                return $order->tickets;
            });

            list($filled, $empty) = $tickets->partition(function ($t) {
                return $t->user_id;
            });

            return $this->result([
                'Filled' => $filled->count(),
                'Empty' => $empty->count(),
            ])->colors([
                'Filled' => '#009999',
                'Empty' => '#f2b716',
            ]);
        } else {
            return $this->result([
                'Filled' => Ticket::whereNotNull('user_id')->count(),
                'Empty' => Ticket::whereNull('user_id')->count(),
            ])->colors([
                'Filled' => '#009999',
                'Empty' => '#f2b716',
            ]);
        }
    }

    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'event-tickets-filled';
    }
}
