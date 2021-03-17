<?php

namespace App\Http\Livewire\App;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.app.home')
            ->layout('layouts.app', ['title' => '']);
    }
}
