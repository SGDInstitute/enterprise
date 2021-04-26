<?php

namespace App\Http\Livewire\Galaxy;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.galaxy.dashboard')
            ->layout('layouts.galaxy', ['title' => 'Dashboard']);
    }
}
