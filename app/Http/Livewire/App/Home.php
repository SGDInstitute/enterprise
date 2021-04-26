<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use App\Models\Form;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.app.home')
            ->layout('layouts.app', ['title' => ''])
            ->with([
                'events' => $this->events,
                'workshopForms' => $this->workshopForms,
            ]);
    }

    public function getEventsProperty()
    {
        return Event::where('end', '>=', now())->get();
    }

    public function getWorkshopFormsProperty()
    {
        return Form::where('type', 'workshop')->where('start', '<', now())->where('end', '>', now())->get();
    }
}
