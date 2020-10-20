<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\ActivitiesByDateCollection;
use App\Http\Resources\ActivitiesResource;
use App\Http\Resources\FormsResource;
use App\Models\Schedule;

class EventsEvaluationsController extends Controller
{
    public function index($id)
    {
        $forms = Event::find($id)->forms->filter(function ($form) {
            return $form->type === 'evaluation';
        });

        return FormsResource::collection($forms);
    }
}
