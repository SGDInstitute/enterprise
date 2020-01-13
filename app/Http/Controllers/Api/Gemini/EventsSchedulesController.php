<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Event;
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;

class EventsSchedulesController extends Controller
{

    public function index($event)
    {
        $event = Event::findOrFail($event);
        return ScheduleResource::collection(Schedule::where('event_id', $event->id)->with('event')->get());
    }

    public function show($id)
    {
        return new ScheduleResource(Schedule::where('id', $id)->with('event')->first());
    }
}
