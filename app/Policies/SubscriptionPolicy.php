<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function view(User $user, Subscription $subscription)
    {
        return $user->id == $subscription->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Subscription $subscription)
    {
        return $user->id == $subscription->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function delete(User $user, Subscription $subscription)
    {
        return $user->id == $subscription->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }
}
