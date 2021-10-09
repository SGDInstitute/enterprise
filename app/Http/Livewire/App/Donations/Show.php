<?php

namespace App\Http\Livewire\App\Donations;

use App\Models\Donation;
use Livewire\Component;

class Show extends Component
{
    public Donation $donation;

    public function render()
    {
        return view('livewire.app.donations.show');
    }
}
