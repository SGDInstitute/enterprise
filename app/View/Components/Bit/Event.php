<?php

namespace App\View\Components\Bit;

use Illuminate\View\Component;

class Event extends Component
{
    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function render()
    {
        return view('components.bit.event');
    }

    public function url()
    {
        return route('app.events.show', $this->event);
    }

    public function title()
    {
        return $this->event->name;
    }

    public function image()
    {
        return $this->event->getFirstMediaUrl('background') ?? 'https://sgdinstitute.org/assets/headers/homepage-hero1.jpg';
    }

    public function location()
    {
        if($this->event->settings->onsite && $this->event->settings->livestream) {
            return $this->event->location . ' & Virtual';
        } elseif($this->event->settings->onsite) {
            return $this->event->location;
        } else {
            return 'Virtual';
        }
    }

    public function dates()
    {
        if($this->event->start->diffInHours($this->event->end) > 24) {
            return $this->event->start->timezone($this->event->timezone)->format('D, M j') . ' - ' . $this->event->end->timezone($this->event->timezone)->format('D, M j, Y');
        } else {
            return $this->event->start->timezone($this->event->timezone)->format('D, M j Y g:i a') . ' - ' . $this->event->end->timezone($this->event->timezone)->format('g:i a');
        }
    }
}
