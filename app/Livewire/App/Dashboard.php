<?php

namespace App\Livewire\App;

use Livewire\Component;

class Dashboard extends Component
{
    public $page;

    public function mount($page = 'orders-reservations')
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.app.dashboard');
    }
}
