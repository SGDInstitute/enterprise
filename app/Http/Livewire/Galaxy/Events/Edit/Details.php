<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Carbon;
use App\Http\Livewire\Traits\WithTimezones;

class Details extends Component
{
    use WithTimezones;

    public Event $event;
    public $formattedEnd;
    public $formattedStart;
    public $formChanged = false;

    public $rules = [
        'event.name' => 'required',
        'formattedStart' => 'required',
        'formattedEnd' => 'required',
        'event.timezone' => 'required',
        'event.location' => '',
        'event.order_prefix' => '',
        'event.description' => 'required',
    ];

    public function mount()
    {
        $this->formattedStart = $this->event->formattedStart;
        $this->formattedEnd = $this->event->formattedEnd;
    }

    public function updating($field)
    {
        if(in_array($field, array_keys($this->rules))) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.details')
            ->with([
                'timezones' => $this->timezones,
            ]);
    }

    public function save()
    {
        $this->validate();

        $this->event->start = Carbon::parse($this->formattedStart, $this->event->timezone)->timezone('UTC');
        $this->event->end = Carbon::parse($this->formattedEnd, $this->event->timezone)->timezone('UTC');

        $this->event->save();

        $this->formChanged = false;
        $this->emit('notify', ['message' => 'Successfully updated event details.', 'type' => 'success']);
    }
}
