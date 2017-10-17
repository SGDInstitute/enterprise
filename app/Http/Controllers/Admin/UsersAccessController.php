<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:manage_roles']);
    }

    public function create()
    {
        return view('admin.users.access.create', [
            'users' => User::all(),
            'roles' => Role::pluck('name', 'id'),
            'permissions' => Permission::pluck('name', 'id'),
        ]);
    }

    public function store()
    {
        foreach (request()->users as $id) {
            $user = User::find($id);
            $user->roles()->attach(request()->roles);
            $user->permissions()->attach(request()->permissions);
        }

        return redirect(route('admin.roles'));
    }

    public function edit(User $user)
    {
        return view('admin.users.access.edit', [
            'user' => $user,
            'users' => User::all(),
            'roles' => Role::pluck('name', 'id'),
            'permissions' => Permission::pluck('name', 'id'),
        ]);
    }

    public function update(User $user)
    {
        $user->roles()->sync(request()->roles ? request()->roles : []);
        $user->permissions()->sync(request()->permissions ? request()->permissions : []);

        return redirect(route('admin.roles'));
    }
}
