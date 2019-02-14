<?php

namespace App\Http\Controllers\Api;

use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function show($id)
    {
        if(is_numeric($id)) {
            return Ticket::find($id)->load(['user.profile']);
        } else {
            return Ticket::findByHash($id)->load(['user.profile']);
        }
    }

    public function update($id)
    {
        if(is_numeric($id)) {
            $ticket = Ticket::find($id)->load(['user.profile']);
        } else {
            $ticket = Ticket::findByHash($id)->load(['user.profile']);
        }

        if (request()->has('user_id')) {
            $ticket->user_id = request('user_id');
            $ticket->save();
        } else {
            $data = request()->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'tshirt' => 'nullable',
                'pronouns' => 'nullable',
                'sexuality' => 'nullable',
                'gender' => 'nullable',
                'race' => 'nullable',
                'college' => 'nullable',
            ]);

            $ticket->fillManually($data);
        }
    }
}
