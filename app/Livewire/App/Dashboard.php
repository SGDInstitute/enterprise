<?php

namespace App\Livewire\App;

use Livewire\Component;

class Dashboard extends Component
{
    public $page;

    public function mount($page = null)
    {
        if (auth()->check() && auth()->user()->has_invitations && $page === null) {
            $page = 'invitations';
        } elseif ($page === null) {
            $page = 'orders-reservations';
        }

        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.app.dashboard');
    }
}
