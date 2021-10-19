<?php

namespace App\Http\Livewire\Galaxy\Config;

use Livewire\Component;

class RecurringDonations extends Component
{
    public function render()
    {
        return view('livewire.galaxy.config.recurring-donations')
            ->layout('layouts.galaxy', ['title' => 'Configure Recurring Donations']);
    }
}
