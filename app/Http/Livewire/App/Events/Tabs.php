<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Tabs extends Component
{
    public Event $event;

    public $active = 'Description';

    public function render()
    {
        return view('livewire.app.events.tabs')
            ->with([
                'options' => $this->options
            ]);
    }

    public function getOptionsProperty()
    {
        return [
            'Description',
            'Photo Policy',
            'Refund Policy',
            'FAQ',
        ];
    }

    public function setActive($option)
    {
        $this->active = $option;
    }
}
