<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Donation;
use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Donations extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public $oneTimePerPage = 10;
    public $recurringPerPage = 10;

    public function render()
    {
        return view('livewire.app.dashboard.donations')
            ->with([
                'oneTimeDonations' => $this->oneTimeDonations,
                'recurringDonations' => $this->recurringDonations,
            ]);
    }

    public function getOneTimeDonationsProperty()
    {
        return Donation::query()
            ->oneTime()
            ->where('user_id', auth()->id())
            ->paginate($this->oneTimePerPage);
    }

    public function getRecurringDonationsProperty()
    {
        return Donation::query()
            ->recurring()
            ->where('user_id', auth()->id())
            ->paginate($this->recurringPerPage);
    }
}
