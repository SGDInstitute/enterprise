<?php

namespace App\Imports;

use App\Content;
use App\Event;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContentImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $event = Event::where('title', $row['event'])->first();

        return new Content([
            'event_id' => $event->id,
            'type' => $row['type'],
            'title' => $row['title'],
            'content' => $row['content'],
        ]);
    }
}
