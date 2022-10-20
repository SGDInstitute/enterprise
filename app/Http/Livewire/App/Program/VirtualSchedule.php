<?php

namespace App\Http\Livewire\App\Program;

use App\Models\Event;
use App\Models\EventItem;
use Livewire\Component;

class VirtualSchedule extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.app.program.virtual-schedule')
            ->with([
                'items' => $this->items,
            ]);
    }

    public function getItemsProperty()
    {
        return EventItem::where('event_id', $this->event->id)
            ->withAnyTags(['Virtual'], 'tracks')
            ->orderBy('start')
            ->get();
    }
}
