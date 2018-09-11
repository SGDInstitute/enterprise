<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function impersonate($userId)
    {
        if (cannot(request()->user(), 'impersonate')) {
            return back();
        }

        $causer = Auth::user();

        request()->session()->flush();

        // We will store the original user's ID in the session so we can remember who we
        // actually are when we need to stop impersonating the other user, which will
        // allow us to pull the original user back out of the database when needed.
        request()->session()->put('sgdinstitute:impersonator', request()->user()->id);
        request()->session()->put('sgdinstitute:url', back()->getTargetUrl());

        $user = User::findOrFail($userId);
        Auth::login($user);

        activity()->performedOn($user)->causedBy($causer)->log(':causer.name impersonated :subject.name');

        return redirect('/home');
    }

    public function stopImpersonating()
    {
        $current = Auth::user();

        // We will make sure we have an impersonator's user ID in the session and if the
        // value doesn't exist in the session we will log this user out of the system
        // since they aren't really impersonating anyone and manually hit this URL.
        if (!request()->session()->has('sgdinstitute:impersonator')) {
            Auth::logout();

            return redirect('/');
        }

        $userId = request()->session()->pull('sgdinstitute:impersonator');
        $url = request()->session()->pull('sgdinstitute:url');

        // After removing the impersonator user's ID from the session so we can retrieve
        // the original user. Then, we will flush the entire session to clear out any
        // stale data from while we were doing the impersonation of the other user.
        request()->session()->flush();

        $user = User::findOrFail($userId);
        Auth::login($user);

        activity()->performedOn($current)->causedBy($user)->log(':causer.name stopped impersonating :subject.name');

        return ($url !== null) ? redirect($url) : redirect('/admin');
    }
}
