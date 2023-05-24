<?php

namespace App\Http\Livewire\App\MessageBoard\Post;

use App\Models\Event;
use App\Models\Post;
use Livewire\Component;

class Show extends Component
{
    public Event $event;
    public Post $post;

    public function render()
    {
        return view('livewire.app.message-board.post.show');
    }
}
