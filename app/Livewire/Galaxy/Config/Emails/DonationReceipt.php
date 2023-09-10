<?php

namespace App\Livewire\Galaxy\Config\Emails;

use App\Models\Donation;
use App\Models\Setting;
use App\Notifications\DonationReceipt as Notification;
use Livewire\Component;

class DonationReceipt extends Component
{
    public $editPanel = false;

    public $rules = [
        'title.payload' => 'required',
        'content.payload' => 'required',
    ];

    public function render()
    {
        $donation = Donation::factory()->make();

        return view('livewire.galaxy.config.emails.donation-receipt')
            ->with([
                'html' => (new Notification($donation))->toMail($donation->user),
                'settings' => $this->settings,
            ]);
    }

    public function getSettingsProperty()
    {
        return Setting::where('group', 'emails.donation-receipt')->get();
    }

    public function saveContent()
    {
        $this->validate();

        $this->title->save();
        $this->content->save();

        $this->dispatch('notify', ['message' => 'Saved content.', 'type' => 'success']);
        $this->editPanel = false;
    }
}
