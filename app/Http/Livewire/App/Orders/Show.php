<?php

namespace App\Http\Livewire\App\Orders;

use App\Models\Order;
use Livewire\Component;

class Show extends Component
{
    public Order $order;
    public $page;

    public function mount($page = 'payment')
    {
        if ($this->order->isPaid()) {
            $this->page === 'tickets';
        }
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.app.orders.show', [
                'steps' => $this->steps,
            ]);
    }

    public function getStepsProperty()
    {
        return [
            ['title' => 'Add/Delete Tickets', 'complete' => false, 'current' => false],
            ['title' => 'Pay Now or Get Invoice', 'complete' => false, 'current' => $this->page === 'payment', 'route' => route('app.orders.show', [$this->order, 'payment'])],
            ['title' => 'Assign Tickets', 'complete' => false, 'current' => $this->page === 'tickets', 'route' => route('app.orders.show', [$this->order, 'tickets'])],
        ];
    }
}
