<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::all()]);
    }

    public function show($id)
    {
        return view('admin.users.show', [
            'user' => User::find($id)->load('orders.event', 'donations', 'roles', 'permissions')
        ]);
    }
}
