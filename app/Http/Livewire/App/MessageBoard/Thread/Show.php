<?php

namespace App\Http\Livewire\App\MessageBoard\Thread;

use App\Models\Event;
use App\Models\Thread;
use Livewire\Component;

class Show extends Component
{
    public Event $event;
    public Thread $thread;
    
    public function render()
    {
        return view('livewire.app.message-board.thread.show');
    }
}
