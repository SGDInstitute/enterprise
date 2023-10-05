<?php

namespace App\Livewire\App\Dashboard;

use App\Models\Invitation;
use Livewire\Component;

class Invitations extends Component
{
    public function render()
    {
        return view('livewire.app.dashboard.invitations')
            ->with([
                'invitations' => $this->invitations,
                'verified' => auth()->user()->hasVerifiedEmail(),
            ]);
    }

    public function getInvitationsProperty()
    {
        return Invitation::where('email', auth()->user()->email)->get();
    }
}
