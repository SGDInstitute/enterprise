<?php

namespace App\Http\Livewire\Galaxy\Events;

use App\Http\Livewire\Traits\WithTimezones;
use App\Models\Event;
use Livewire\Component;

class Details extends Component
{
    use WithTimezones;

    public Event $event;
    public $formChanged = false;

    public $rules = [
        'event.name' => 'required',
        'event.start' => 'required',
        'event.end' => 'required',
        'event.timezone' => 'required',
        'event.location' => '',
        'event.order_prefix' => '',
        'event.description' => 'required',
    ];

    public function updating($field)
    {
        if(in_array($field, array_keys($this->rules))) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.details')
            ->with([
                'timezones' => $this->timezones,
            ]);
    }

    public function save()
    {
        $this->event->save();

        $this->formChanged = false;
        // notify
    }
}
