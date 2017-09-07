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

        flash()->success("We've sent you a magic link! The link expires in 10 minutes.");
        return redirect()->back();
    }

    public function authenticate(UserToken $token)
    {
        if ($token->isExpired()) {
            $token->delete();
            flash()->error('That magic link has expired.');
            return redirect('/login/magic');
        }

        if (!$token->belongsToUser(request('email'))) {
            $token->delete();
            flash()->error('Invalid magic link.');
            return redirect('/login/magic');
        }

        Auth::login($token->user, request('remember'));
        $token->delete();
        return redirect('/home');
    }
}
