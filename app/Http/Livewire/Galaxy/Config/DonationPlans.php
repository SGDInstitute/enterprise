<?php

namespace App\Http\Livewire\Galaxy\Config;

use Livewire\Component;

class DonationPlans extends Component
{
    public function render()
    {
        return view('livewire.galaxy.config.donation-plans')
            ->layout('layouts.galaxy', ['title' => 'Configure Donation Plans']);
    }
}
