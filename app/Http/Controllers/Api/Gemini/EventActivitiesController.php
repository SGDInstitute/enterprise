<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Activity;
use App\Event;
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesResource;
use App\Http\Resources\ScheduleResource;

class EventActivitiesController extends Controller
{

    public function index($id)
    {
        $activities = Schedule::where('event_id', $id)->with('activities.type')->get()->flatMap(function ($schedule) {
            return $schedule->activities->map(function ($activity) use ($schedule) {
                $activity->schedule = $schedule->title;
                return $activity;
            });
        });

        return ActivitiesResource::collection($activities);
    }

    public function show($id)
    {
    }
}
