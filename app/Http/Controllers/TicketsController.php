<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function update($hash)
    {
        $ticket = Ticket::findByHash($hash);

        if (request()->has('user_id')) {
            $ticket->user_id = request('user_id');
            $ticket->save();
        }
        else {
            $data = request()->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'tshirt' => 'required',
                'pronouns' => 'nullable',
                'sexuality' => 'nullable',
                'gender' => 'nullable',
                'race' => 'nullable',
                'college' => 'nullable',
                'accommodation' => 'nullable',
            ]);

            $ticket->fillManually($data);
        }
    }
}
