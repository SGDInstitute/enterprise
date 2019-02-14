<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function show($id)
    {
        if(is_numeric($id)) {
            return \App\Ticket::find($id)->load(['user.profile']);
        } else {
            return \App\Ticket::where('hash', $id)->with(['user.profile'])->firstOrFail();
        }
    }
}
