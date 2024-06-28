<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('institute')) {
            return true;
        }
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->user_id || $user->id === $ticket->order->user_id;
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->id === $ticket->order->user_id;
    }
}
