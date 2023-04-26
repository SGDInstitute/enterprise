<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->hasRole('institute')) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Order $order): bool
    {
        $ticketHolders = $order->tickets()->select('user_id')->whereNotNull('user_id')->pluck('user_id');

        return $order->user_id === $user->id || $ticketHolders->contains($user->id);
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Order $order): bool
    {
        return $order->user_id === $user->id;
    }

    public function delete(User $user, Order $order): bool
    {
        return $order->user_id === $user->id;
    }

    public function restore(User $user, Order $order): bool
    {
        //
    }

    public function forceDelete(User $user, Order $order): bool
    {
        //
    }
}
