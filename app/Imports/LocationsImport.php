<?php

namespace App\Imports;

use App\Event;
use App\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LocationsImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $event = Event::where('title', $row['event'])->first();

        return new Location([
            'event_id' => $event->id,
            'title' => $row['title'],
            'bbreviation' => $row['abbreviation'],
            'type' => $row['type'],
            'description' => $row['description'],
            'address_line_1' => $row['address_line_1'],
            'address_line_2' => $row['address_line_2'],
            'city' => $row['city'],
            'state' => $row['state'],
            'postal_code' => $row['postal_code'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
        ]);
    }
}
