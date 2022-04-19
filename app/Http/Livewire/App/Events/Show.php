<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public $showPreviousOrders = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        if (request()->query('edit')) {
            // check if user is authorized to view
            $this->load(request()->query('edit'));
        } else {
            if ($this->previousOrders->count() > 0) {
                $this->showPreviousOrders = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.app.events.show', [
            'steps' => $this->steps,
        ]);
    }

    public function getPreviousOrdersProperty()
    {
        if (auth()->check()) {
            return auth()->user()->orders()->where('event_id', $this->event->id)->get();
        }

        return collect([]);
    }

    public function getStepsProperty()
    {
        return [
            ['title' => 'Add/Delete Tickets', 'complete' => false, 'current' => true],
            ['title' => 'Pay Now or Get Invoice', 'complete' => false, 'current' => false],
            ['title' => 'Assign Tickets', 'complete' => false, 'current' => false],
        ];
    }

    private function load($id)
    {
        $this->order = $this->previousOrders->firstWhere('id', $id);
        $this->tickets = $this->order->tickets;
    }
}
