<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Donation;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithPagination;
use Stripe\BillingPortal\Session;

class Donations extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

    public $perPage = 10;
    public $thankYouModal = false;
    public $thankYouTitle;
    public $thankYouContent;

    public function render()
    {
        if (request()->query('thank-you')) {
            $this->thankYouModal = true;

            $settings = Setting::where('group', 'donations.thank-you-modal')->get();
            $this->thankYouTitle = $settings->firstWhere('name', 'title')->payload;
            $this->thankYouContent = $settings->firstWhere('name', 'content')->payload;
        }

        return view('livewire.app.dashboard.donations')
            ->with([
                'donations' => $this->donations,
                'subscription' => $this->subscription,
            ]);
    }

    // Properties

    public function getDonationsProperty()
    {
        return Donation::query()
            ->where('user_id', auth()->id())
            ->where('type', 'one-time')
            ->paginate($this->perPage);
    }

    public function getSubscriptionProperty()
    {
        return Donation::query()
            ->where('user_id', auth()->id())
            ->where('type', 'monthly')
            ->first();
    }

    // Methods

    public function cancel()
    {
        $this->subscription->cancel();

        $this->emit('notify', ['message' => 'Successfully canceled subscription.', 'type' => 'success']);
        $this->emit('$refresh');
    }

    public function openPortal()
    {
        $session = Session::create(['customer' => auth()->user()->stripe_id, 'return_url' => route('app.dashboard', ['page' => 'donations'])]);

        return redirect($session->url);
    }
}
