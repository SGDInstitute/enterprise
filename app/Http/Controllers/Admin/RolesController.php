<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:manage_roles']);
    }

    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::with('permissions')->get(),
            'permissions' => Permission::with('roles')->get(),
            'users' => User::has('roles')->orHas('permissions')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.roles.create', [
            'permissions' => Permission::pluck('name', 'id'),
        ]);
    }

    public function store()
    {
        request()->name = str_snake(request()->name);

        $data = request()->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ]);

        $role = Role::create(['name' => $data['name']]);
        $role->permissions()->sync($data['permissions']);

        return redirect(route('admin.roles'));
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', [
            'permissions' => Permission::pluck('name', 'id'),
            'role' => $role,
        ]);
    }

    public function update(Role $role)
    {
        $data = request()->validate([
            'name' => 'required',
            'permissions' => 'required|array',
        ]);

        $role->name = $data['name'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return redirect(route('admin.roles'));
    }
}
