<?php

namespace App\Http\Livewire\App\Program;

use App\Models\Event;
use Livewire\Component;

class BulletinBoard extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.app.program.bulletin-board');
    }
}