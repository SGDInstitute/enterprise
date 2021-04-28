<?php

namespace App\Http\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Tabs extends Component
{
    public Event $event;

    public $active = 'Description';
    public $tabs;

    public function mount()
    {
        $this->tabs = $this->event->settings->tabs ?? [];
    }

    public function render()
    {
        return view('livewire.app.events.tabs')
            ->with([
                'activeContent' => $this->activeContent,
                'options' => $this->options
            ]);
    }

    public function getActiveContentProperty()
    {
        $content = '';
        if($this->active === 'Description') {
            $content = $this->event->description;
        } else {
            $filtered = array_values(array_filter($this->tabs, fn($tab) => $tab['name'] === $this->active));
            $content = $filtered[0]['content'];
        }

        return markdown($content);
    }

    public function getOptionsProperty()
    {
        $tabs = array_column($this->tabs, 'name');
        array_unshift($tabs , 'Description');

        return $tabs;
    }

    public function setActive($option)
    {
        $this->active = $option;
    }
}
