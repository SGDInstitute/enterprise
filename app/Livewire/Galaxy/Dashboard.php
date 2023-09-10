<?php

namespace App\Livewire\Galaxy;

use App\Models\Event;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.galaxy.dashboard')
            ->layout('layouts.galaxy', ['title' => 'Dashboard'])
            ->with([
                'event' => Event::find(8),
            ]);
    }
}
