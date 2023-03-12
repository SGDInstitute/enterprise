<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Event;
use App\Models\EventBadgeQueue;
use Livewire\Component;
use Livewire\WithPagination;

class Queue extends Component
{
    use WithSorting;
    use WithFiltering;
    use WithPagination;

    public Event $event;

    public $perPage = 100;

    public $selected = [];

    protected $listeners = ['refresh' => '$refresh'];

    public function updated($field, $value)
    {
        $badges = $this->queue->whereIn('id', $value);

        if ($badges) {
            $badges->each(fn ($badge) => $badge->markAsPrinted());

            $this->emit('refresh');
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.queue')
            ->layout('layouts.galaxy', ['title' => 'Queue for ' . $this->event->name])
            ->with([
                'queue' => $this->queue,
            ]);
    }

    public function getQueueProperty()
    {
        return EventBadgeQueue::query()
            ->where('printed', false)
            ->paginate($this->perPage);
    }
}
