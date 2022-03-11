<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;

class Donations extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public $perPage = 10;
    public $thankYouModal = false;
    public $thankYouTitle;
    public $thankYouContent;

    public function render()
    {
        if(request()->query('thank-you')) {
            $this->thankYouModal = true;

            $settings = Setting::where('group', 'donations.thank-you-modal')->get();
            $this->thankYouTitle = $settings->firstWhere('name', 'title')->payload;
            $this->thankYouContent = $settings->firstWhere('name', 'content')->payload;
        }

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

    public function cancel($id)
    {
        $this->donations->firstWhere('id', $id)->cancel();

        $this->emit('notify', ['message' => 'Successfully canceled subscription.', 'type' => 'success']);
        $this->emit('$refresh');
    }
}
