<?php

namespace App\Exports;

use App\Models\Event;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VolunteersExport implements FromView
{
    public function __construct(public Event $event)
    {
        $this->event->load('shifts.users');
    }

    public function view(): View
    {
        return view('exports.volunteers', [
            'shifts' => $this->event->shifts,
        ]);
    }
}
