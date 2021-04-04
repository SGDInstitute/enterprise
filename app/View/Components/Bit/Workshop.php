<?php

namespace App\View\Components\Bit;

use Illuminate\View\Component;

class Workshop extends Component
{
    public $workshopForm;

    public function __construct($workshopForm)
    {
        $this->workshopForm = $workshopForm;
    }

    public function render()
    {
        return view('components.bit.workshop');
    }

    public function url()
    {
        return route('app.forms.show', $this->workshopForm);
    }

    public function title()
    {
        return $this->workshopForm->name;
    }

    public function image()
    {
        return $this->workshopForm->event->getFirstMediaUrl('background') ?? 'https://sgdinstitute.org/assets/headers/homepage-hero1.jpg';
    }

    public function dates()
    {
        if($this->workshopForm->start->diffInHours($this->workshopForm->end) > 24) {
            return $this->workshopForm->start->timezone($this->workshopForm->timezone)->format('D, M j') . ' - ' . $this->workshopForm->end->timezone($this->workshopForm->timezone)->format('D, M j, Y');
        } else {
            return $this->workshopForm->start->timezone($this->workshopForm->timezone)->format('D, M j Y g:i a') . ' - ' . $this->workshopForm->end->timezone($this->workshopForm->timezone)->format('g:i a');
        }
    }
}
