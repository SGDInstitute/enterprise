<?php

namespace App\Policies;

use App\Donation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DonationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function view(User $user, Donation $donation)
    {
        return $user->id == $donation->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Donation $donation)
    {
        return $user->id == $donation->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function delete(User $user, Donation $donation)
    {
        return $user->id == $donation->user_id || $user->hasRole('institute') || $user->hasRole('developer');
    }
}
