<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'reports' => ['accommodation', 'tshirt', 'orders', 'paid-registrants', 'unpaid-registrants', 'all-registrants']
        ]);
    }
}
