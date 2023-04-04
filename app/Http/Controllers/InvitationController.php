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
        if (auth()->check() && auth()->user()->email === $invitation->email) {
            return $invitation->accept();
        }

        if (auth()->check() && auth()->user()->email !== $invitation->email) {
            auth()->logout();
        }

        if (User::firstWhere('email', $invitation->email)) {
            return redirect()->route('login');
        } else {
            return redirect()->route('register');
        }
    }
}
