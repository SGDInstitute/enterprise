<?php

namespace App\Exports;

use App\Models\EventItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class ScheduleExport implements FromCollection
{
    public function __construct(public $eventId) {}

    public function collection()
    {
        return EventItem::where('event_id', $this->eventId)->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'description' => $item->description ? trim($item->description) : null,
                'speaker' => $item->speaker,
                'location' => $item->location,
                'duration' => $item->formattedDuration,
                'tracks' => $item->tracks,
                'warnings' => $item->warnings,
            ];
        });
    }
}
