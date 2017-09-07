<?php

namespace App\Http\Controllers;

use App\Mail\UserConfirmationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function update()
    {
        request()->user()->update(request()->all());
        request()->user()->profile()->update(request()->except('name', 'email'));
    }
}
