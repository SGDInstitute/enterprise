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
    public $user;

    public $filters = [
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
            ->join('events', 'orders.event_id', '=', 'events.id')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->when($this->user, function($query) {
                $query->forUser($this->user);
            })
            ->when($this->event, function($query) {
                $query->forEvent($this->event);
            })
            ->when($this->filters['search'], function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $search = trim($search);
                    $query->where('events.name', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%')
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('orders.id', $search);
                });
            })
            ->select('orders.*', 'users.name', 'events.name', 'users.email')
            ->with('tickets', 'event', 'user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
}
