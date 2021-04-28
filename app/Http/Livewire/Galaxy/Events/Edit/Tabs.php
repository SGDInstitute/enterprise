<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;

class Tabs extends Component
{
    public Event $event;

    public $tabs;


    public function mount()
    {
        $this->tabs = $this->event->settings->tabs ?? [];
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.tabs');
    }

    // Properties

    // Methods

    public function addTab()
    {
        $this->tabs[] = ['name' => '', 'content' => ''];
    }

    public function save()
    {
        $this->event->settings->set('tabs', $this->tabs);
        $this->event->save();

        $this->emit('notify', ['message' => 'Successfully saved tabs', 'type' => 'success']);
    }
}
