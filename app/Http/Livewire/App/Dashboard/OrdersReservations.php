<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersReservations extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

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
            ->with('tickets')
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
            ->with('tickets')
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
