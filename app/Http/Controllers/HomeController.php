<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use League\Flysystem\File;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'orders' => [
                'upcoming' => request()->user()->upcomingOrdersAndTickets(),
                'past' => request()->user()->pastOrdersAndTickets(),
            ],
            'donations' => request()->user()->donations,
            'upcomingEvents' => Event::published()->upcoming()->get(),
        ]);
    }

    public function changelog()
    {
        return view('changelog', [
            'content' => markdown(app('files')->get(base_path('/CHANGELOG.md'))),
        ]);
    }
}
