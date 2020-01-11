<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Location;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;

class EventLocationsController extends Controller
{
    public function index($id)
    {
        $locations = Location::where('event_id', $id)->with('floors.rooms')->get();

        return LocationResource::collection($locations);
    }
}
