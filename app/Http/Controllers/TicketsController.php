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
        } else {
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
                'send_email' => 'nullable',
                'message' => 'nullable',
            ]);

            $ticket->fillManually($data);
        }
    }

    public function destroy($hash) 
    {
        $ticket = Ticket::findByHash($hash);
        $this->authorize('delete', $ticket->order);

        if (!$ticket->order->isPaid()) {
            $ticket->delete();

            flash()->success('Successfully deleted ticket.');
            
            return back();
        }

        flash()->error('Cannot delete an order that has been paid.');
        return response([], 412);
    }
}
