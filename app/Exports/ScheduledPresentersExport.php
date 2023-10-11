<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\EventItem;
use App\Models\Response;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScheduledPresentersExport implements FromCollection, WithHeadings
{
    public function __construct(public Event $event)
    {
    }

    public function collection()
    {
        return EventItem::where('event_id', $this->event->id)
            ->where('settings->workshop_id', '<>', null)
            ->get()
            ->flatMap(function ($item) {
                $response = Response::find($item->settings->workshop_id);

                return $response->collaborators->map(fn ($user) => [
                    'name' => trim($item->name),
                    'speaker' => $user->name,
                    'email' => $user->email,
                    'pronouns' => $user->pronouns,
                    'location' => $item->location,
                    'duration' => $item->formattedDuration,
                ]);
            });
    }

    public function headings(): array
    {
        return [
            'Workshop',
            'Name',
            'Email',
            'Pronouns',
            'Location',
            'Duration',
        ];
    }
}
