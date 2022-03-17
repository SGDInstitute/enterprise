<?php

namespace App\Http\Livewire\Galaxy;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Reservations extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

    protected $listeners = ['refresh' => '$refresh'];

    public $event;
    public $user;

    public $filters = [
        'search' => '',
    ];
    public $invoices = [];
    public $selectAll = false;
    public $selectPage = false;
    public $selected = [];
    public $showInvoiceModal = false;
    public $perPage = 25;

    public function updatedSelectPage($value)
    {
        $this->selected = ($value) ? $this->rows->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function updatedSelected($value)
    {
        if (isset($value[0])) {
            $this->invoices[$value[0]] = ['check' => '', 'amount' => ''];
        }
    }

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
                        ->orWhere('users.name', 'like', '%' . $search . '%')
                        ->orWhere('orders.id', $search)
                        ->orWhere('orders.id', substr($search, 3));
                });
            })
            ->select('orders.*', 'users.name', 'events.name', 'users.email')
            ->with('tickets', 'event', 'user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function comp()
    {
        $this->reservations->whereIn('id', $this->selected)
            ->each(fn ($order) => $order->markAsPaid('comped', 0));

        $this->emit('refresh');
        $this->emit('notify', ['message' => 'Successfully marked ' . count($this->selected) . ' reservations as comped.', 'type' => 'success']);

        $this->reset('selected');
    }

    public function markAsPaid()
    {
        $this->reservations->whereIn('id', $this->selected)
            ->each(fn ($order) => $order->markAsPaid($this->invoices[$order->id]['check'], $this->invoices[$order->id]['amount'] * 100));

        $this->emit('refresh');
        $this->emit('notify', ['message' => 'Successfully marked ' . count($this->selected) . ' reservations as paid.', 'type' => 'success']);

        $this->reset('selected', 'invoices', 'showInvoiceModal');
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }
}
