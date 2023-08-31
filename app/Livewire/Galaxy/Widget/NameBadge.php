<?php

namespace App\Livewire\Galaxy\Widget;

use App\Models\EventBadgeQueue;
use Livewire\Component;

class NameBadge extends Component
{
    public $name;

    public $pronouns;

    protected $rules = [
        'name' => 'required',
        'pronouns' => '',
    ];

    public function render()
    {
        return view('livewire.galaxy.widget.name-badge');
    }

    public function submit()
    {
        $this->validate();

        EventBadgeQueue::create([
            'name' => $this->name,
            'pronouns' => $this->pronouns,
        ]);

        $this->dispatch('notify', ['message' => 'Successfully added to queue', 'type' => 'success']);
        $this->reset('name', 'pronouns');
    }
}
