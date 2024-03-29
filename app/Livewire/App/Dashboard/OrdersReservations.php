<?php

namespace App\Livewire\App\Dashboard;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersReservations extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $filters = [
        'search' => '',
    ];

    public $ordersPerPage = 25;

    public $ordersView = 'grid';

    public $reservationsPerPage = 25;

    public $reservationsView = 'grid';

    public function render()
    {
        return view('livewire.app.dashboard.orders-reservations')
            ->with([
                'orders' => $this->orders,
                'reservations' => $this->reservations,
            ]);
    }

    public function getOrdersProperty()
    {
        return Order::query()
            ->paid()
            ->leftJoin('tickets', 'tickets.order_id', '=', 'orders.id')
            ->with(['tickets', 'event'])
            ->where(function ($query) {
                $query->where('orders.user_id', auth()->id())
                    ->orWhere('tickets.user_id', auth()->id());
            })
            ->select('orders.*')
            ->groupBy('orders.id')
            ->orderBy('created_at', 'desc')
            ->paginate($this->ordersPerPage);
    }

    public function getReservationsProperty()
    {
        return Order::query()
            ->reservations()
            ->leftJoin('tickets', 'tickets.order_id', '=', 'orders.id')
            ->with(['tickets', 'event'])
            ->where(function ($query) {
                $query->where('orders.user_id', auth()->id())
                    ->orWhere('tickets.user_id', auth()->id());
            })
            ->select('orders.*')
            ->groupBy('orders.id')
            ->orderBy('created_at', 'desc')
            ->paginate($this->reservationsPerPage);
    }
}
