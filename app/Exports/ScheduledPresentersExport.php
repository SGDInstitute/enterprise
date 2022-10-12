<?php

namespace App\Exports;

use App\Models\EventItem;
use App\Models\Response;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduledPresentersExport implements FromCollection
{
    public function __construct(public $event)
    {
    }

    public function collection()
    {
        return Response::where('form_id', $this->event->workshopForm->id)
            ->where('status', 'scheduled')
            ->get();
    }

    // public function headings(): array
    // {
    //     return [
    //         'Order ID',
    //         'Name',
    //         'Email',
    //         'Pronouns',
    //         'Transaction ID',
    //         'Ticket Type',
    //         'Ticket ID',
    //     ];
    // }
}
