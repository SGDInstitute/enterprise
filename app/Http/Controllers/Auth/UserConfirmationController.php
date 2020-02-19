<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserConfirmationEmail;
use App\UserToken;
use Illuminate\Http\Request;
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
        if (request()->user()) {
            request()->user()->sendConfirmationEmail();
        }

        return redirect()->back();
    }
}
