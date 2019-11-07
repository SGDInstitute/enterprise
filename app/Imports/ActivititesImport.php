<?php

namespace App\Imports;

use App\Activity;
use App\ActivityType;
use App\Nova\Activity as AppActivity;
use App\Schedule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ActivititesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        $schedule = Schedule::where('title', $row['schedule_title'])->first();
        $type = ActivityType::where('title', $row['type'])->first();

        return new Activity([
            'schedule_id' => $schedule->id,
            'activity_type_id' => $type->id,
            'title' => $row['title'],
            'description' => $row['description'],
            'location' => $row['location'],
            'start' => Date::excelToDateTimeObject($row['start']),
            'end' => Date::excelToDateTimeObject($row['end']),
        ]);
    }
}
