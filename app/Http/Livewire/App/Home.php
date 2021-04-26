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
        return Event::all();
    }

    public function getWorkshopFormsProperty()
    {
        return Form::where('type', 'workshop')->get();
    }
}
