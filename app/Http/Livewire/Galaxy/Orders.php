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

    public $fiters = [
        'search' => '',
    ];
    public $perPage = 25;

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
            ->when($this->event, function($query) {
                $query->forEvent($this->event);
            })
            ->paginate($this->perPage);
    }
}
