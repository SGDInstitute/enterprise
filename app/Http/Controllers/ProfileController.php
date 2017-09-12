<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmationEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function update(User $user = null)
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
            'accommodation' => ''
        ]);

        if(is_null($user)) {
            $user = request()->user();
        }

        $oldEmail = $user->email;

        $user->update($userData);

        if(request('email') !== $oldEmail) {
            $user->sendConfirmationEmail();
        }

        $user->profile()->update($profile);

        return response()->json(['success' => true], 200);
    }
}
