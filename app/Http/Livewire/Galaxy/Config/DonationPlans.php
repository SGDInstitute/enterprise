<?php

namespace App\Http\Livewire\Galaxy\Config;

use App\Models\DonationPlan as Plan;
use Livewire\Component;

class DonationPlans extends Component
{
    public function render()
    {
        return view('livewire.galaxy.config.donation-plans')
            ->layout('layouts.galaxy', ['title' => 'Configure Donation Plans'])
            ->with([
                'plans' => $this->plans
            ]);
    }

    public function getPlansProperty()
    {
        return Plan::with('prices')->get();
    }
}
