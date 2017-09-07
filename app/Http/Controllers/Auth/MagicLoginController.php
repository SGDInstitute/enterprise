<?php

namespace App\Http\Controllers\Auth;

use App\Mail\MagicLoginEmail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MagicLoginController extends Controller
{
    public function show()
    {
        return view('auth.magic');
    }
    
    public function sendToken()
    {
        $user = User::findByEmail(request('email'));

        $user->createToken();

        Mail::to($user->email)->send(new MagicLoginEmail($user));
    }
}
