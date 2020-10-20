<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Event;
use App\Http\Controllers\Controller;
use App\Schedule;
use Illuminate\Http\Request;

class EventsSchedulesController extends Controller
{
    public function index($event)
    {
        $event = Event::findOrFail($event);
        $schedules = Schedule::where('event_id', $event->id)->with('event')->get()->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'event' => $schedule->event->title,
                'title' => $schedule->title,
            ];
        });

        return response()->json(['data' => $schedules]);
    }

    public function show($id)
    {
        $schedule = Schedule::find($id);
        dd($schedule);
        $schedule = Schedule::where('id', $id)->with('event')->first();
        dd($schedule);

        return response()->json([
            'data' => [
                'id' => $schedule->id,
                'event' => $schedule->event->title,
                'title' => $schedule->title,
            ],
        ]);
    }
}
