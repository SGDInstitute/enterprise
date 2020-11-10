<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('welcome', [
            'upcomingEvents' => Event::published()->upcoming()->get(),
        ]);
    }
}
