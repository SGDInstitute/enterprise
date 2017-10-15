<?php

namespace App\Http\Controllers\Admin;

use App\Donation;
use App\Http\Controllers\Controller;

class DonationsController extends Controller
{
    public function index()
    {
        return view('admin.donations.index', [
            'donations' => Donation::with('user')->get(),
            'recurring' => Donation::with('user', 'subscription')->subscriptions()->get(),
        ]);
    }
}
