<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{

    public function show(User $user = null)
    {
        if ($user === null) {
            return new UserResource(auth()->user());
        } else {
            return new UserResource($user);
        }
    }

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

        $oldEmail = $user->email;

        $user->update($userData);

        if (request('email') !== $oldEmail) {
            $user->sendConfirmationEmail();
        }

        $user->profile()->update($profile);

        return response()->json(['success' => true], 200);
    }
}
