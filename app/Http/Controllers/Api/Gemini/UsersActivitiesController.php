<?php

namespace App\Http\Controllers\Api\Gemini;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesByDateCollection;
use App\Http\Resources\ActivitiesCollection;
use App\Http\Resources\ActivitiesResource;
use App\Schedule;

class UsersActivitiesController extends Controller
{

    public function index()
    {
        $activities = auth()->user()->schedule()->with('speakers', 'schedule.event', 'type')->get()
            ->filter(function ($activity) {
                return $activity->schedule->event->id == request()->query('event');
            })
            ->map(function ($activity) {
                $activity->timezone = $activity->schedule->event->timezone;
                $activity->schedule = $activity->schedule->title;
                return $activity;
            })
            ->sortBy('start');

        return ActivitiesResource::collection($activities);
    }

    public function store($id)
    {
        auth()->user()->schedule()->toggle($id);

        if (request()->query('event')) {
            $activities = auth()->user()->fresh()->schedule()->with('speakers', 'schedule.event', 'type')->get()
                ->filter(function ($activity) {
                    return $activity->schedule->event->id == request()->query('event');
                })
                ->map(function ($activity) {
                    $activity->timezone = $activity->schedule->event->timezone;
                    $activity->schedule = $activity->schedule->title;
                    return $activity;
                })
                ->sortBy('start');

            return ActivitiesResource::collection($activities);
        } else {
            return response()->json([], 201);
        }
    }
}
