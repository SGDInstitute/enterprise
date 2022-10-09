<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Order $order)
    {
        $ticketHolders = $order->tickets()->select('user_id')->whereNotNull('user_id')->pluck('user_id');

        return $order->user_id === $user->id || $ticketHolders->contains($user->id);
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Order $order)
    {
        //
    }

    public function delete(User $user, Order $order)
    {
        //
    }

    public function restore(User $user, Order $order)
    {
        //
    }

    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
