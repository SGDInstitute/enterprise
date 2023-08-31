<?php

namespace App\Livewire\Galaxy\Orders;

use App\Models\Order;
use Livewire\Component;

class Show extends Component
{
    public $listeners = ['refresh' => '$refresh'];

    public Order $order;

    public function mount()
    {
        $this->order->load('user', 'event', 'tickets');
    }

    public function render()
    {
        $title = ($this->order->isPaid() ? 'Order ' : 'Reservation ') . $this->order->formattedId;

        return view('livewire.galaxy.orders.show')
            ->layout('layouts.galaxy', ['title' => $title]);
    }
}
