<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesByDateCollection;
use App\Http\Resources\ActivitiesResource;

class EventsActivitiesController extends Controller
{

    public function index($id)
    {
        $activities = Schedule::where('event_id', $id)->with('activities.type', 'activities.speakers.profile', 'event')->get()->flatMap(function ($schedule) {
            return $schedule->activities->map(function ($activity) use ($schedule) {
                $activity->schedule = $schedule->title;
                $activity->timezone = $schedule->event->timezone;
                return $activity;
            });
        });

        list($workshops, $notWorkshops) = $activities->partition(function ($a) {
            return $a->type->title === 'workshop';
        });

        $notWorkshops = $notWorkshops->sortBy('start');

        foreach ($notWorkshops as $activity) {
            if ($activity->type->title === 'group') {
                $activity->workshops = $workshops->where('start', $activity->start)->sortBy('title')->map->toArray()->values();
            }
        }

        if (request()->query('groupBy') === 'date') {
            return ActivitiesByDateCollection::collection($notWorkshops
                ->groupBy(function ($activity) {
                    return $activity->start->format('Y-m-d');
                }));
        }

        return ActivitiesResource::collection($notWorkshops);
    }
}
