<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function show($id)
    {
        if (is_numeric($id)) {
            return Ticket::find($id)->load(['user.profile']);
        } else {
            return Ticket::findByHash($id)->load(['user.profile']);
        }
    }

    public function update($id)
    {
        if (is_numeric($id)) {
            $ticket = Ticket::find($id)->load(['user.profile']);
        } else {
            $ticket = Ticket::findByHash($id)->load(['user.profile']);
        }

        if (request()->has('user_id')) {
            $ticket->user_id = request('user_id');
            $ticket->save();
        } elseif ($user = User::findByEmail(request('email'))) {
            $ticket->user_id = $user->id;
            $ticket->save();

            $userData = request()->validate([
                'name' => 'required',
                'email' => 'required',
            ]);

            $profile = request()->validate([
                'pronouns' => '',
                'sexuality' => '',
                'gender' => '',
                'race' => '',
                'college' => '',
                'tshirt' => '',
            ]);

            $user->update($userData);
            $user->profile->update($profile);
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
