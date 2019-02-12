<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function store(User $user)
    {
        $userData = request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $profile = request()->validate([
            'pronouns' => '',
            'sexuality' => '',
            'gender' => '',
            'race' => '',
            'college' => '',
            'tshirt' => '',
        ]);

        if (is_null($user)) {
//            $user = request()->user();
        }

        $oldEmail = $user->email;

        $user->update($userData);

        if (request('email') !== $oldEmail) {
            $user->sendConfirmationEmail();
        }

        $user->profile()->update($profile);

        return response()->json(['success' => true], 200);
    }
}
