<?php

namespace App\Http\Controllers\Api\Gemini;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\NewTicket;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{
    public function store()
    {
        $data = request()->validate([
            'subject' => 'required',
            'message' => 'required'
        ]);

        Mail::to('support@sgdinstitute.org')
            ->cc(auth()->user()->email)
            ->send(new NewTicket($data['subject'], $data['message'], auth()->user()->email));

        return response()->json(['message' => 'Successful']);
    }
}
