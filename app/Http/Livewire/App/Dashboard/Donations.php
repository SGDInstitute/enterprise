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

    public $perPage = 10;

    public function render()
    {
        return view('livewire.app.dashboard.donations')
            ->with([
                'donations' => $this->donations,
            ]);
    }

    // Properties

    public function getDonationsProperty()
    {
        return Donation::query()
            ->where('user_id', auth()->id())
            ->paginate($this->perPage);
    }

    // Methods

    public function cancel()
    {
        auth()->user()->subscription('default')->cancel();

        $this->emit('notify', ['message' => 'Successfully cancelled subscription.', 'type' => 'success']);
        $this->emit('$refresh');
    }
}
