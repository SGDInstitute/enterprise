<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Order $order;

    public $page;

    public function mount($page = 'payment')
    {
        $this->authorize('view', $this->order);

        if ($this->order->user_id !== auth()->id()) {
            $this->page = 'tickets';
        } elseif ($this->order->isPaid()) {
            $this->page = 'tickets';
        } else {
            $this->page = $page;
        }
    }

    public function render()
    {
        return view('livewire.app.orders.show', [
            'steps' => $this->steps,
        ]);
    }

    public function delete()
    {
        if ($this->order->isPaid()) {
            return $this->emit('notify', ['message' => 'Cannot delete a paid order', 'type' => 'error']);
        }

        $this->order->safeDelete();

        return redirect()->route('app.dashboard');
    }

    public function getStepsProperty()
    {
        return [
            ['title' => 'Add/Delete Tickets', 'complete' => true, 'current' => false, 'route' => route('app.orders.show', [$this->order, 'start'])],
            ['title' => 'Pay Now or Get Invoice', 'complete' => $this->order->isPaid(), 'current' => $this->page === 'payment', 'route' => route('app.orders.show', [$this->order, 'payment'])],
            ['title' => 'Assign Tickets', 'complete' => $this->order->isFilled(), 'current' => $this->page === 'tickets', 'route' => route('app.orders.show', [$this->order, 'tickets'])],
        ];
    }
}
