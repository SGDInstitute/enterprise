<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user)
    {
        return $user->hasRole('institute') || $user->hasRole('developer');
    }

    public function view(User $user, Role $role)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Role $role)
    {
        //
    }

    public function delete(User $user, Role $role)
    {
        //
    }

    public function restore(User $user, Role $role)
    {
        //
    }

    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
