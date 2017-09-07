<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserConfirmationEmail;
use App\UserToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserConfirmationController extends Controller
{
    public function store(UserToken $token)
    {

        $user = $token->user;
        $user->confirm();

        return redirect()->intended('/home');
    }

    public function create()
    {
        if(request()->user()) {
            request()->user()->createToken('email');
            Mail::to(request()->user())->send(new UserConfirmationEmail(request()->user()));
        }

        return redirect()->back();
    }
}
