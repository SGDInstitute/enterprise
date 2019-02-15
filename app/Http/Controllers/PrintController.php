<?php

namespace App\Http\Controllers;

use App\Queue;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function __invoke($ids)
    {
        $tickets = Queue::whereIn('id', explode(',', $ids))->get();

        return view('genesis.print', [
            'tickets' => $tickets
        ]);
    }
}
