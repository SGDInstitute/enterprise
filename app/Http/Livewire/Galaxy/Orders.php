<?php

namespace App\Http\Livewire\Galaxy;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Mail\PartialRefund;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

    public $event;

    public $user;

    public $filters = [
        'search' => '',
    ];

    public $selectAll = false;

    public $selectPage = false;

    public $selected = [];

    public $showPartialModal = false;

    public $perPage = 25;

    public $editingOrder;

    public $editingTickets = [];

    public function updatedSelectPage($value)
    {
        $this->selected = ($value) ? $this->orders->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function render()
    {
        return view('livewire.galaxy.orders')
            ->layout('layouts.galaxy', ['title' => 'Orders'])
            ->with([
                'editingTicketsAmount' => $this->editingTicketsAmount,
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
                    $query->where('events.name', 'like', '%'.$search.'%')
                        ->orWhere('users.email', 'like', '%'.$search.'%')
                        ->orWhere('orders.confirmation_number', 'like', '%'.$search.'%')
                        ->orWhere('orders.transaction_id', 'like', '%'.$search.'%')
                        ->orWhere('orders.amount', 'like', '%'.$search.'%')
                        ->orWhere('users.name', 'like', '%'.$search.'%')
                        ->orWhere('orders.id', $search)
                        ->orWhere('orders.id', substr($search, 3));
                });
            })
            ->select('orders.*', 'users.name', 'events.name', 'users.email')
            ->with('tickets', 'event', 'user')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function getEditingTicketsAmountProperty()
    {
        if (count($this->editingTickets) > 0) {
            return $this->editingOrder->tickets->whereIn('id', $this->editingTickets)->sum(fn ($ticket) => $ticket->price->cost);
        }
    }

    public function openPartialModal()
    {
        $this->editingOrder = $this->orders->firstWhere('id', $this->selected[0]);
        $this->showPartialModal = true;
    }

    public function partialRefund()
    {
        if ($this->editingOrder->isStripe()) {
            $refund = $this->editingOrder->user->refund($this->editingOrder->transaction_id, ['amount' => $this->editingTicketsAmount]);
            activity()->performedOn($this->editingOrder)->withProperties(['amount' => $this->editingTicketsAmount, 'refund_id' => $refund->id])->log('partial_refund');
        } else {
            activity()->performedOn($this->editingOrder)->withProperties(['amount' => $this->editingTicketsAmount, 'refund_id' => 'check'])->log('partial_refund');
        }

        $this->editingOrder->amount = $this->editingOrder->amount - $this->editingTicketsAmount;
        $this->editingOrder->save();
        $this->editingOrder->tickets->whereIn('id', $this->editingTickets)->each->delete();

        Mail::to($this->editingOrder->user)->send(new PartialRefund($this->editingOrder, $this->editingTicketsAmount, count($this->editingTickets)));

        $this->reset('editingOrder', 'editingTickets', 'selected');
        $this->emit('notify', ['message' => 'Partial refund processed', 'type' => 'success']);
    }

    public function resetPartialModal()
    {
        $this->showPartialModal = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
    }
}
