<?php

namespace App\Http\Controllers;

use App\Event;
use App\Form;

class HomeController extends Controller
{
    public function index()
    {
        list($openWorkshops, $openSurveys) = Form::open()->get()->partition(function ($form) {
            return $form->type === 'workshop';
        });

        $responses = auth()->user()->responses->load('form.event');
        $submittedWorkshops = $responses->filter(function ($response) {
            return $response->form->type === 'workshop';
        });

        $submittedUpcomingVolunteer = $responses->filter(function ($response) {
            return $response->form->type === 'volunteer' && $response->form->event->start > now();
        })->first();

        if ($submittedUpcomingVolunteer !== null) {
            $volunteerActivities = $submittedUpcomingVolunteer->form->event->schedules()->where('title', 'Volunteer Track')
                ->with('activities.type', 'activities.users', 'activities.location')
                ->get()->flatMap->activities;
        }

        return view('home', [
            'orders' => [
                'upcoming' => auth()->user()->upcomingOrdersAndTickets(),
                'past' => auth()->user()->pastOrdersAndTickets(),
            ],
            'donations' => auth()->user()->donations,
            'upcomingEvents' => Event::published()->upcoming()->get(),
            'openWorkshops' => $openWorkshops,
            'openSurveys' => $openSurveys,
            'submittedWorkshops' => $submittedWorkshops,
            'volunteerActivities' => $volunteerActivities ?? collect([]),
        ]);
    }

    public function changelog()
    {
        return view('changelog', [
            'content' => markdown(app('files')->get(base_path('/CHANGELOG.md'))),
        ]);
    }
}
