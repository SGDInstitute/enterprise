<?php

namespace App\Livewire\App\Orders;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Order $order;

    public $page;

    public function mount($page = null)
    {
        $this->authorize('view', $this->order);

        if ($this->order->user_id !== auth()->id()) {
            $this->page = 'attendee';
        } elseif ($this->order->isPaid() && $page === null) {
            $this->page = 'tickets';
        } elseif ($page === null) {
            $this->page = 'payment';
        }
    }

    public function render()
    {
        return view('livewire.app.orders.show');
    }

    public function delete()
    {
        if ($this->order->isPaid()) {
            return $this->dispatch('notify', ['message' => 'Cannot delete a paid order', 'type' => 'error']);
        }

        $this->order->safeDelete();

        return redirect()->route('app.dashboard');
    }
}
