<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesByDateCollection;
use App\Http\Resources\ActivitiesResource;
use App\Schedule;

class EventsActivitiesController extends Controller
{
    public function index($id)
    {
        $activities = Schedule::where('event_id', $id)
            ->where('title', '!=', 'Volunteer Track')
            ->with('activities.type', 'activities.location', 'activities.room', 'activities.speakers.profile', 'event')
            ->get()
            ->flatMap(function ($schedule) {
                return $schedule->activities->map(function ($activity) use ($schedule) {
                    $activity->schedule = $schedule->title;
                    $activity->timezone = $schedule->event->timezone;

                    return $activity;
                });
            });

        $workshops = $activities->filter(function ($a) {
            return $a->type->title === 'workshop';
        });

        $activities = $activities->sortBy('start');

        foreach ($activities as $activity) {
            if ($activity->type->title === 'group') {
                $activity->workshops = $workshops->where('start', $activity->start)->sortBy('title')->map->toArray()->values();
            }
        }

        if (request()->query('groupBy') === 'date') {
            return ActivitiesByDateCollection::collection($activities
                ->groupBy(function ($activity) {
                    return $activity->start->format('Y-m-d');
                }));
        }

        return ActivitiesResource::collection($activities);
    }
}
