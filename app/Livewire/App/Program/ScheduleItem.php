<?php

namespace App\Livewire\App\Program;

use App\Models\Event;
use App\Models\EventItem;
use Filament\Notifications\Notification;
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

        $this->dispatch('refresh');

        Notification::make()
            ->success()
            ->title('Successfully added ' . $this->item->name . ' to your schedule.')
            ->send();
    }

    public function remove()
    {
        auth()->user()->schedule()->detach($this->item);

        $this->dispatch('refresh');

        Notification::make()
            ->success()
            ->title('Successfully removed ' . $this->item->name . ' from your schedule.')
            ->send();
    }
}
