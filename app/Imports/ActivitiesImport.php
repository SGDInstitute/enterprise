<?php

namespace App\Imports;

use App\Activity;
use App\ActivityType;
use App\Location;
use App\Nova\Activity as AppActivity;
use App\Room;
use App\Schedule;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ActivitiesImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        if ($row['type'] !== null) {
            $schedule = Schedule::where('title', $row['schedule'])->first();
            $type = ActivityType::firstOrCreate(['title' => $row['type']]);

            $start = new Carbon(Date::excelToDateTimeObject($row['start'])->format('Y-m-d H:i:s'), $schedule->event->timezone);
            $start->tz('UTC');
            $end = new Carbon(Date::excelToDateTimeObject($row['end'])->format('Y-m-d H:i:s'), $schedule->event->timezone);
            $end->tz('UTC');


            if ($row['location'] !== null) {
                $location = Location::where('title', $row['location'])->orWhere('abbreviation', $row['location'])->first()->id;
            } else {
                $location = null;
            }

            if ($row['room'] !== '' && $row['room'] !== null) {
                if (is_string($row['room'])) {
                    $room = Room::where('title', $row['room'])->first();
                } else {
                    $room = Room::where('number', $row['room'])->first();
                }

                if ($room !== null) {
                    $room = $room->id;
                } else {
                    dd($row['room']);
                }
            } else {
                $room = null;
            }

            $activity = new Activity([
                'schedule_id' => $schedule->id,
                'activity_type_id' => $type->id,
                'title' => $row['title'],
                'description' => $row['description'] ?? null,
                'location_id' => $location,
                'room_id' => $room,
                'start' => $start,
                'end' => $end,
                'spots' => $row['spots'] ?? null,
            ]);

            if ($row['speaker'] !== null && $row['type'] === 'workshop') {
                $response = $schedule->event->forms()->where('type', 'workshop')->first()->responses()->where('responses->name', utf8_encode($row['title']))->first();
                if ($response !== null) {
                    $activity->save();
                    $activity->speakers()->attach($response->user_id);
                }
            }

            return $activity;
        }
    }
}
