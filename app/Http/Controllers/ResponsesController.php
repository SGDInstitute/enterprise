<?php

namespace App\Http\Controllers;

use App\Mail\ResponseConfirmationEmail;
use App\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResponsesController extends Controller
{
    public function edit(Response $response)
    {
        return view('responses.edit', [
            'form' => $response->form,
            'response' => $response,
        ]);
    }

    public function update(Response $response)
    {
        if ($response->form->type === 'workshop' && ! auth()->check()) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        request()->validate($response->form->getRules());

        $response->responses = request()->except(['_token', 'busy', 'errors', 'successful', 'email']);
        $response->save();

        if (isset($response->email)) {
            Mail::to(request()->email)->send(new ResponseConfirmationEmail($response));
        } elseif (isset($response->user)) {
            Mail::to($response->user)->send(new ResponseConfirmationEmail($response));
        }

        return response()->json([
            'response' => $response,
            'success' => true,
            'url' => '/forms/thank-you',
        ]);
    }
}
