<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = request()->user();
        if(is_null(request()->user()->profile)) {
            $user->profile()->save(new Profile());
            $user->fresh();
        }

        return view('settings.edit', [
            'user' => $user
        ]);
    }
}
