<?php

namespace App\Livewire\Galaxy\Donations;

use App\Models\Donation;
use Livewire\Component;

class Show extends Component
{
    public Donation $donation;

    public function render()
    {
        return view('livewire.galaxy.donations.show')
            ->layout('layouts.galaxy', ['title' => 'Donation']);
    }
}
