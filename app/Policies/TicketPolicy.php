<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Ticket $ticket)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->user_id || $user->id === $ticket->order->user_id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->id === $ticket->order->user_id;
    }

    public function restore(User $user, Ticket $ticket)
    {
        //
    }

    public function forceDelete(User $user, Ticket $ticket)
    {
        //
    }
}
