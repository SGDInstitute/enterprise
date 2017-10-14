<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:manage_roles']);
    }

    public function create()
    {
        return view('admin.permissions.create', [
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    public function store()
    {
        request()->name = str_snake(request()->name);

        $data = request()->validate([
            'name' => 'required|unique:permissions,name',
            'roles' => 'nullable|array',
        ]);

        $permission = Permission::create(['name' => $data['name']]);
        $permission->roles()->sync(request()->roles);

        $developer = Role::findByName('developer');
        if (!$developer->hasPermissionTo($permission)) {
            $developer->givePermissionTo($permission);
        }

        return redirect(route('admin.roles'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', [
            'permission' => $permission,
            'roles' => Role::pluck('name', 'id'),
        ]);
    }

    public function update(Permission $permission)
    {
        $data = request()->validate([
            'name' => 'required',
            'roles' => 'nullable|array',
        ]);

        $permission->name = $data['name'];
        $permission->save();

        $permission->roles()->sync($data['roles']);

        return redirect(route('admin.roles'));
    }
}
