<?php

namespace App\Http\Controllers;

use App\Mail\ResponseConfirmationEmail;
use App\Response;
use App\Form;
use Hocza\Sendy\Facades\Sendy;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class FormsResponsesController extends Controller
{

    public function create($slug)
    {
        $form = Form::findBySlug($slug);
        return view('forms.responses.create', compact('form'));
    }

    public function store(Form $form)
    {
        if ($form->type === 'workshop' && !auth()->check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        request()->validate($form->getRules());

        $response = $form->responses()->create([
            'responses' => request()->except(['_token', 'busy', 'errors', 'successful', 'email']),
            'request' => request()->server(),
            'email' => request()->email,
            'user_id' => auth()->id() ?? null,
        ]);

        if (!is_null($form->list_id) && $response->email) {
            Sendy::setListId($form->list_id)->unsubscribe($response->email);
        }

        if (isset($response->email)) {
            Mail::to(request()->email)->send(new ResponseConfirmationEmail($response));
        }

        return response()->json([
            'response' => $response,
            'success' => true,
            'url' => '/forms/thank-you',
        ]);
    }

    public function show(Form $form)
    {
        return $form;
    }
}
