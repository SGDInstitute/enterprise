<?php

namespace App\Http\Livewire\App\Program;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;

class Badge extends Component
{
    public Event $event;

    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.app.program.badge');
    }
}
