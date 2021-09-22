<?php

namespace App\Http\Livewire\Galaxy;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public $event;
    public $user;

    public $filters = [
        'search' => '',
    ];
    public $selectAll = false;
    public $selectPage = false;
    public $selected = [];
    public $perPage = 25;

    public function updatedSelectPage($value)
    {
        $this->selected = ($value) ? $this->rows->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function render()
    {
        return view('livewire.galaxy.orders')
            ->layout('layouts.galaxy', ['title' => 'Orders'])
            ->with([
                'orders' => $this->orders,
            ]);
    }

    public function getOrdersProperty()
    {
        return Order::paid()
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->when($this->user, function ($query) {
                $query->forUser($this->user);
            })
            ->when($this->event, function ($query) {
                $query->forEvent($this->event);
            })
            ->when($this->filters['search'], function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $search = trim($search);
                    $query->where('events.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%')
                        ->orWhere('orders.confirmation_number', 'like', '%' . $search . '%')
                        ->orWhere('orders.transaction_id', 'like', '%' . $search . '%')
                        ->orWhere('orders.amount', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('orders.id', $search);
                });
            })
            ->select('orders.*', 'users.name', 'events.name', 'users.email')
            ->with('tickets', 'event', 'user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }
}
