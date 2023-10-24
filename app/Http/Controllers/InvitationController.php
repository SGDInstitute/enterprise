<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function accept(Request $request, $invitationId)
    {
        $invitation = Invitation::find($invitationId);
        if (auth()->check() && strtolower(auth()->user()->email) === strtolower($invitation->email)) {
            return $invitation->accept();
        }

        if (auth()->check() && strtolower(auth()->user()->email) !== strtolower($invitation->email)) {
            auth()->logout();
        }

        if (User::firstWhere('email', $invitation->email)) {
            $request->session()->flash('status', 'Login to accept invitation.');
            $request->session()->put('url.intended', $invitation->acceptUrl);

            return redirect()->route('login');
        } else {
            $request->session()->flash('status', 'Create an account to accept invitation.');
            $request->session()->put('url.intended', $invitation->acceptUrl);

            return redirect()->route('register');
        }
    }
}
