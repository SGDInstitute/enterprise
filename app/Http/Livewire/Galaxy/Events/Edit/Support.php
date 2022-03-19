<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Models\Event;
use Livewire\Component;

class Support extends Component
{
    public Event $event;

    public $contact;

    public $faq;

    public function mount()
    {
        $this->contact = $this->event->settings->contact;
        $this->faq = $this->event->settings->faq ?? [];
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.support');
    }

    public function addTab()
    {
        $this->faq[] = ['name' => '', 'content' => ''];
    }

    public function save()
    {
        $this->event->settings->set('faq', $this->faq);
        $this->event->save();

        $this->emit('notify', ['message' => 'Successfully saved FAQ', 'type' => 'success']);
    }

    public function saveContact()
    {
        $this->event->settings->set('contact', $this->contact);
        $this->event->save();

        $this->emit('notify', ['message' => 'Successfully saved Contact Page', 'type' => 'success']);
    }
}
