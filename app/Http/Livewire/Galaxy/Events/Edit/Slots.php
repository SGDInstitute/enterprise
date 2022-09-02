<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\EventItem;
use Livewire\Component;

class Slots extends Component
{
    public Event $event;

    public EventItem $item;

    public $editingItem;

    public $editingTracks;

    public $showItemModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'editingItem.name' => 'required',
        'editingItem.location' => 'required',
        'editingItem.description' => 'required',
    ];

    public function mount()
    {
        $this->editingItem = new EventItem();
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.slots')
            ->layout('layouts.galaxy', ['title' => $this->event->name.' '.$this->item->name])
            ->with([
                'collisions' => $this->collisions,
                'items' => $this->items,
            ]);
    }

    public function getCollisionsProperty()
    {
        return $this->items
            ->groupBy('location')
            ->filter(fn ($location) => $location->count() > 1)
            ->map(function ($location) {
                return $location->map(fn ($item) => $item->id);
            });
    }

    public function getItemsProperty()
    {
        return $this->event->items->where('parent_id', $this->item->id);
    }

    public function openItemModal($id = null)
    {
        if ($id !== null) {
            $item = $this->items->firstWhere('id', $id);
            $this->editingItem = $item;
            $this->editingTracks = $item->tracks;
        }

        $this->showItemModal = true;
    }

    public function resetItemModal()
    {
        $this->editingItem = new EventItem();
        $this->reset('editingTracks', 'showItemModal');
    }

    public function saveLocation()
    {
        $this->editingItem->save();

        $this->emit('refresh');
        $this->reset('editingItem');
        $this->emit('notify', ['message' => 'Saved location.', 'type' => 'success']);
    }

    public function saveItem()
    {
        $this->editingItem->event_id = $this->event->id;
        $this->editingItem->start = $this->item->start;
        $this->editingItem->end = $this->item->end;
        $this->editingItem->timezone = $this->item->timezone;
        $this->editingItem->parent_id = $this->item->id;
        $this->editingItem->save();

        $this->editingItem->syncTagsWithType(explode(',', $this->editingTracks), 'tracks');

        $this->emit('notify', ['message' => 'Successfully saved item', 'type' => 'success']);

        $this->resetItemModal();
        $this->emit('refresh');
    }

    public function setLocation($id)
    {
        $this->editingItem = $this->items->firstWhere('id', $id);
    }
}
