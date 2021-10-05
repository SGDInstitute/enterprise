<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\EventItem;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Schedule extends Component
{
    public Event $event;

    public $editingItem;
    public $editingTracks;
    public $showItemModal = false;

    public $form = [
        'date' => '',
        'start' => '',
        'end' => '',
    ];

    public $rules = [
        'editingItem.name' => 'required',
        'editingItem.description' => '',
        'editingItem.location' => '',
        'editingTrack.name' => 'required',
        'editingTrack.description' => '',
        'editingTrack.color' => '',
    ];

    public function mount()
    {
        $this->editingItem = new EventItem;
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.schedule')
            ->with([
                'end' => $this->end,
                'items' => $this->items,
                'tracks' => $this->event->tracks,
                'start' => $this->start,
            ]);
    }

    // Properties

    public function getEndProperty()
    {
        return $this->event->end->timezone($this->event->timezone);
    }

    public function getItemsProperty()
    {
        return $this->event->items;
    }

    public function getStartProperty()
    {
        return $this->event->start->timezone($this->event->timezone);
    }


    // Methods

    public function changeItemDateTime($id, $start, $end)
    {
        $item = $this->items->firstWhere('id', $id);
        $item->start = Carbon::parse($start, $item->timezone)->timezone('UTC');
        $item->end = Carbon::parse($end, $item->timezone)->timezone('UTC');

        $item->save();

        $this->emit('notify', ['message' => 'Saved', 'type' => 'success']);
    }

    public function openItemModal($id = null)
    {
        if(is_numeric($id)) {
            $item = $this->items->firstWhere('id', $id);
            $this->editingItem = $item;
            $this->editingTracks = $item->tagsWithType('tracks')->pluck('name')->join(',');

            $this->form['date'] = $item->start->timezone($item->timezone)->format('m/d/Y');
            $this->form['start'] = $item->start->timezone($item->timezone)->format('H:i');
            $this->form['end'] = $item->end->timezone($item->timezone)->format('H:i');
        } else {
            $date = Carbon::parse($id, $this->event->timezone);

            $this->form['date'] = $date->format('m/d/Y');
            $this->form['start'] = $date->format('H:i');
            $this->form['end'] = $date->clone()->addHour()->format('H:i');
        }

        $this->showItemModal = true;
    }

    public function redirectToSlot()
    {
        return redirect()->route('galaxy.events.edit.slots', [$this->event, $this->editingItem]);
    }

    public function resetItemModal()
    {
        $this->showItemModal = false;
        $this->editingItem = new EventItem;
        $this->reset('form', 'editingTracks');
    }

    public function saveItem()
    {
        $this->editingItem->event_id = $this->event->id;
        $this->editingItem->start = Carbon::parse($this->form['date'] . ' ' . $this->form['start'], $this->event->timezone)->timezone('UTC');
        $this->editingItem->end = Carbon::parse($this->form['date'] . ' ' . $this->form['end'], $this->event->timezone)->timezone('UTC');
        $this->editingItem->timezone = $this->event->timezone;
        $this->editingItem->save();

        $this->editingItem->syncTagsWithType(explode(',', $this->editingTracks), 'tracks');

        $this->emit('notify', ['message' => 'Successfully saved item', 'type' => 'success']);

        $this->resetItemModal();
        $this->emit("refreshCalendar");
    }
}
