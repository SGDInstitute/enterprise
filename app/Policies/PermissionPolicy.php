<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function view(User $user, Permission $permission)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Permission $permission)
    {
        //
    }

    public function delete(User $user, Permission $permission)
    {
        //
    }

    public function restore(User $user, Permission $permission)
    {
        //
    }

    public function forceDelete(User $user, Permission $permission)
    {
        //
    }
}
