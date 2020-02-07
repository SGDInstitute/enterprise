<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActivityUserExport implements FromView
{
    public $schedule;

    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    public function view() : View
    {
        return view('exports.gemini.activity_user', [
            'schedule' => $this->schedule,
        ]);
    }
}
