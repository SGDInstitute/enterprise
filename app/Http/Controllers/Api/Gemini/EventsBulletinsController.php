<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Bulletin;
use App\Http\Controllers\Controller;
use App\Http\Resources\BulletinResource;

class EventsBulletinsController extends Controller
{
    public function index($event)
    {
        $bulletins = Bulletin::where('event_id', $event)->get();

        return BulletinResource::collection($bulletins);
    }
}
