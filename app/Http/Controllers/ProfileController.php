<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function update()
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $oldEmail = request()->user()->email;

        request()->user()->update(request()->all());

        if(request('email') !== $oldEmail) {
            request()->user()->sendConfirmationEmail();
        }

        request()->user()->profile()->update(request()->except('name', 'email'));
    }
}
