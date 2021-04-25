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
        return $this->event->backgroundUrl;
    }

    public function location()
    {
        return $this->event->formattedLocation;
    }

    public function dates()
    {
        return $this->event->formattedDuration;
    }
}
