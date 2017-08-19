<?php

namespace App\Http\Controllers;

use App\Rules\MatchesUsersPassword;
use Illuminate\Http\Request;

class SettingPasswordsController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'old_password' => ['required', new MatchesUsersPassword],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'regex:/^((?=.*?[A-Z])(?=.*?[a-z])(?=.*?\d)|(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[^a-zA-Z0-9])|(?=.*?[A-Z])(?=.*?\d)(?=.*?[^a-zA-Z0-9])|(?=.*?[a-z])(?=.*?\d)(?=.*?[^a-zA-Z0-9])).{8,}$/',
            ]
        ]);

        request()->user()->changePassword($data['password']);

        return response()->json(['success' => true], 200);
    }
}
