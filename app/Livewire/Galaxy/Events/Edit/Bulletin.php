<?php

namespace App\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use App\Models\EventBulletin;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Bulletin extends Component
{
    public Event $event;

    public EventBulletin $bulletin;

    public $formChanged = false;

    public $formattedPublish;

    protected $listeners = ['refresh' => '$refresh'];

    protected $rules = [
        'bulletin.title' => 'required',
        'bulletin.content' => 'required',
        'formattedPublish' => 'required',
        'bulletin.timezone' => 'required',
        'bulletin.notify' => 'boolean',
    ];

    public function mount()
    {
        $this->resetBulletin();
    }

    public function updating($field)
    {
        if (in_array($field, array_keys($this->rules))) {
            $this->formChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.bulletin');
    }

    public function add()
    {
        $this->validate();

        $this->bulletin->published_at = Carbon::parse($this->formattedPublish, $this->bulletin->timezone ?? $this->event->timezone)->timezone('UTC');

        $this->bulletin->event_id = $this->event->id;
        $this->bulletin->timezone = $this->event->timezone;

        $this->bulletin->save();

        $this->formChanged = false;
        $this->dispatch('notify', ['message' => 'Successfully added bulletin.', 'type' => 'success']);

        $this->resetBulletin();
        $this->dispatch('refresh');
    }

    public function resetBulletin()
    {
        $this->bulletin = new EventBulletin(['event_id' => $this->event->id, 'timezone' => $this->event->timezone]);
        $this->formattedPublish = now()->timezone($this->event->timezone)->format('m/d/Y g:i A');
    }
}
