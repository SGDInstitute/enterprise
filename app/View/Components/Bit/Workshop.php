<?php

namespace App\View\Components\Bit;

use Illuminate\View\Component;

class Workshop extends Component
{
    public $form;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function render()
    {
        return view('components.bit.workshop');
    }

    public function url()
    {
        return route('app.forms.show', $this->form);
    }

    public function title()
    {
        return $this->form->name;
    }

    public function image()
    {
        return optional($this->form->event)->getFirstMediaUrl('background') ?? 'https://sgdinstitute.org/assets/headers/homepage-hero1.jpg';
    }

    public function dates()
    {
        if ($this->form->start && $this->form->end) {
            if ($this->form->start->diffInHours($this->form->end) > 24) {
                return $this->form->start->timezone($this->form->timezone)->format('D, M j').' - '.$this->form->end->timezone($this->form->timezone)->format('D, M j, Y');
            } else {
                return $this->form->start->timezone($this->form->timezone)->format('D, M j Y g:i a').' - '.$this->form->end->timezone($this->form->timezone)->format('g:i a');
            }
        }
    }
}
