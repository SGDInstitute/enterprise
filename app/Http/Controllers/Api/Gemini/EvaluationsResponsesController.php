<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Event;
use App\Form;
use App\Http\Controllers\Controller;
use App\Http\Resources\FormsResource;
use App\Http\Resources\ResponseResource;
use App\Mail\ResponseConfirmationEmail;
use Illuminate\Support\Facades\Mail;

class EvaluationsResponsesController extends Controller
{
    public function store($id)
    {
        $form = Form::find($id);

        request()->validate($form->getRules());

        $response = $form->responses()->create([
            'responses' => request()->except(['_token', 'busy', 'errors', 'successful', 'email']),
            'request' => request()->server(),
            'email' => auth()->user()->email,
            'user_id' => auth()->id() ?? null,
        ]);

        return new ResponseResource($response);
    }
}
