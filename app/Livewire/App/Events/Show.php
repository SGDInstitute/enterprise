<?php

namespace App\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public $showPreviousOrders = false;

    public $order;

    public $tickets;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        if (request()->query('edit')) {
            // @todo check if user is authorized to view
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
            'previousOrders' => $this->previousOrders,
        ]);
    }

    public function getPreviousOrdersProperty()
    {
        if (auth()->check()) {
            return auth()->user()->orders()->where('event_id', $this->event->id)->get();
        }

        return collect([]);
    }

    private function load($id)
    {
        $this->order = $this->previousOrders->firstWhere('id', $id);
        $this->tickets = $this->order->tickets;
    }
}
