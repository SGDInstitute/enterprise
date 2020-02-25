<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(User $user = null)
    {
        $userData = request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $profile = request()->validate([
            'pronouns' => '',
            'sexuality' => '',
            'gender' => '',
            'race' => '',
            'college' => '',
            'tshirt' => '',
            'accessibility' => '',
            'other_accessibility' => '',
            'language' => '',
            'other_language' => '',
            'agreement' => 'accepted',
        ]);

        if (is_null($user)) {
            $user = request()->user();
        }

        $oldEmail = $user->email;

        $user->update($userData);

        // if (request('email') !== $oldEmail) {
        //     $user->sendConfirmationEmail();
        // }

        $userProfile = $user->profile;

        $userProfile->update($profile);

        return response()->json(['success' => true], 200);
    }
}
