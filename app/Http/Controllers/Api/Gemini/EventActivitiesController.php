<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesResource;

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
}
