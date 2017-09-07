<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function update()
    {
        $user = request()->validate([
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

        $oldEmail = request()->user()->email;

        request()->user()->update($user);

        if(request('email') !== $oldEmail) {
            request()->user()->sendConfirmationEmail();
        }

        request()->user()->profile()->update($profile);
    }
}
