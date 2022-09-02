<?php

namespace App\Http\Livewire\App\Program;

use App\Models\Event;
use App\Models\EventItem;
use Livewire\Component;

class ScheduleItem extends Component
{
    public Event $event;

    public EventItem $item;

    protected $listeners = ['refresh' => '$refresh'];

    public function render()
    {
        return view('livewire.app.program.schedule-item')
            ->layout('layouts.gemini', ['title' => $this->event->name, 'event' => $this->event])
            ->with([
                'isInSchedule' => $this->isInSchedule,
            ]);
    }

    public function getIsInScheduleProperty()
    {
        return auth()->user()->isInSchedule($this->item);
    }

    public function add()
    {
        auth()->user()->schedule()->attach($this->item);

        $this->emit('notify', ['message' => 'Successfully added '.$this->item->name.' to your schedule.', 'type' => 'success']);
        $this->emit('refresh');
    }

    public function remove()
    {
        auth()->user()->schedule()->detach($this->item);

        $this->emit('notify', ['message' => 'Successfully removed '.$this->item->name.' from your schedule.', 'type' => 'success']);
        $this->emit('refresh');
    }
}
