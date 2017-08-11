<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventOrdersController extends Controller
{
    public function store($slug)
    {
//        $event = Event::findBySlug($slug);

        return response()->json(['amount' => 10000], 201);
    }
}
