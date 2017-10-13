<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
}
