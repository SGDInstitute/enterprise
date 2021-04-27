<?php

namespace App\Http\Livewire\Galaxy;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Reservations extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public $event;

    public $fiters = [
        'search' => '',
    ];
    public $perPage = 25;

    public function render()
    {
        return view('livewire.galaxy.reservations')
            ->layout('layouts.galaxy', ['title' => 'Reservations'])
            ->with([
                'reservations' => $this->reservations,
            ]);
    }

    public function getReservationsProperty()
    {
        return Order::reservations()
            ->when($this->event, function($query) {
                $query->forEvent($this->event);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
