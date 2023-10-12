<?php

namespace App\Events;

use App\Models\Event;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ShiftsFellBelowLimit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Event $event, public User $user)
    {
    }
}
