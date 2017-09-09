<?php

namespace App\Http\Controllers;

use App\Mail\InviteUserEmail;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Mail;
use Vinkla\Hashids\Facades\Hashids;

class OrderTicketsController extends Controller
{
    public function update(Order $order)
    {
        request()->validate($this->buildRules(), [
            'emails.*.required_without_all' => 'At least one email needs to be filled out.',
        ]);

        foreach (request('emails') as $hash => $email) {
            if (!empty($email)) {
                Ticket::findByHash($hash)->invite($email, request('message'));
            }
        }
    }

    private function buildRules()
    {
        $rules = [];
        foreach (request('emails') as $hash => $email) {
            $rules["emails.{$hash}"] = 'email|nullable|required_without_all:' . $this->buildString($hash, request('emails'));
        }

        return $rules;
    }

    private function buildString($hash, $emails)
    {
        return collect($emails)->keys()
            ->filter(function ($email) use ($hash) {
                return $email !== $hash;
            })
            ->map(function($email) {
                return "emails." . $email;
            })
            ->implode(',');
    }
}
