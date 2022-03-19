<?php

namespace App\Http\Livewire\Galaxy\Config\Donations;

use App\Models\Setting;
use Livewire\Component;

class ThankYouModal extends Component
{
    public $editPanel = false;

    public $title;

    public $content;

    public $rules = [
        'title.payload' => 'required',
        'content.payload' => 'required',
    ];

    public function mount()
    {
        $this->title = $this->settings->firstWhere('name', 'title');
        $this->content = $this->settings->firstWhere('name', 'content');
    }

    public function render()
    {
        return view('livewire.galaxy.config.donations.thank-you-modal');
    }

    public function getSettingsProperty()
    {
        return Setting::where('group', 'donations.thank-you-modal')->get();
    }

    public function saveContent()
    {
        $this->validate();

        $this->title->save();
        $this->content->save();

        $this->emit('notify', ['message' => 'Saved content.', 'type' => 'success']);
        $this->editPanel = false;
    }
}
