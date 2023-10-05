<?php

namespace App\Livewire\App\Dashboard;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Invitation;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

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
