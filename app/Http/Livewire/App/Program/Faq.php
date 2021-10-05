<?php

namespace App\Http\Livewire\App\Program;

use App\Models\Event;
use Livewire\Component;

class Faq extends Component
{
    public Event $event;

    public function render()
    {
        return view('livewire.app.program.faq');
    }
}
