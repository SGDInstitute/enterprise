<?php

namespace App\Nova\Metrics;

use App\Models\Event;
use App\Nova\Filters\Event as EventFilter;
use App\Models\Order;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Nemrutco\Filterable\FilterablePartition;

class EventTicketsStatus extends Partition
{
    use FilterablePartition;

    public function filters()
    {
        return [new EventFilter];
    }

    public function calculate(NovaRequest $request)
    {
        if ($request->query(\App\Nova\Filters\Event::class)) {
            $event = Event::with('orders.tickets', 'orders.receipt')->find($request->query(\App\Nova\Filters\Event::class));
            $orders = $event->orders;
        } else {
            $orders = Order::with('tickets', 'receipt')->get();
        }

        list($paid, $unpaid) = $orders->partition(function ($order) {
            return $order->confirmation_number;
        });
        list($paid, $comped) = $paid->partition(function ($order) {
            return $order->receipt->transaction_id !== 'comped';
        });

        return $this->result([
            'Paid' => $paid->flatMap->tickets->count(),
            'Comped' => $comped->flatMap->tickets->count(),
            'Unpaid' => $unpaid->flatMap->tickets->count(),
        ])->colors([
            'Paid' => '#009999',
            'Comped' => '#a13c72',
            'Unpaid' => '#f2b716',
        ]);
    }

    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    public function uriKey()
    {
        return 'event-tickets-status';
    }
}
