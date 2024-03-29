<?php

namespace App\Livewire\Galaxy\Events\Edit;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Event;
use App\Models\EventBadgeQueue;
use Livewire\Component;
use Livewire\WithPagination;

class Queue extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public Event $event;

    public $perPage = 100;

    public $selected = [];

    protected $listeners = ['refresh' => '$refresh'];

    public function updated($field, $value)
    {
        $badges = $this->queue->whereIn('id', $value);

        if ($badges) {
            $badges->each(fn ($badge) => $badge->markAsPrinted());

            $this->dispatch('refresh');
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
