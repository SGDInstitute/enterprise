<?php

namespace App\Imports;

use App\Models\Floor;
use App\Models\Location;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FloorsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $location = Location::where('title', $row['location'])->first();

            if ($location !== null) {
                $floor = Floor::create([
                    'location_id' => $location->id,
                    'title' => $row['title'],
                    'level' => $row['level'],
                ]);

                foreach (explode(':', $row['rooms']) as $room) {
                    $exploded = explode(',', $room);

                    if (count($exploded) > 1) {
                        $floor->rooms()->create([
                            'number' => $exploded[0],
                            'title' => $exploded[1],
                        ]);
                    } else {
                        $floor->rooms()->create(['number' => $exploded[0]]);
                    }
                }
            }
        }
    }
}
