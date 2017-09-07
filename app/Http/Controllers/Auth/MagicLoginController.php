<?php

namespace App\Http\Controllers\Auth;

use App\Mail\MagicLoginEmail;
use App\User;
use App\UserToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MagicLoginController extends Controller
{
    public function show()
    {
        return view('auth.magic');
    }
    
    public function sendToken()
    {
        $data = request()->validate([
            'email' => 'required',
            'remember' => '',
        ]);

        $user = User::findByEmail($data['email']);

        if (!$user) {
            flash()->error('User not found, please register.');
            return redirect('/login/magic');
        }

        $user->createToken();

        Mail::to($user->email)->send(new MagicLoginEmail($user, $data));

        flash()->success("We've sent you a magic link! The link expires in 5 minutes.");
        return redirect()->back();
    }

    public function authenticate(UserToken $token)
    {
        Auth::login($token->user, request('remember'));
        $token->delete();
        return redirect('/home');
    }
}
