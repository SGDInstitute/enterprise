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

        list($submittedWorkshops, $submittedSurveys) = auth()->user()->responses->load('form')->partition(function ($response) {
            return $response->form->type === 'workshop';
        });

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
            'submittedSurveys' => $submittedSurveys,
        ]);
    }

    public function changelog()
    {
        return view('changelog', [
            'content' => markdown(app('files')->get(base_path('/CHANGELOG.md'))),
        ]);
    }
}
