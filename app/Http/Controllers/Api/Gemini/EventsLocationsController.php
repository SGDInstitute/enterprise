<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use App\Models\Location;

class EventsLocationsController extends Controller
{
    public function index($id)
    {
        $locations = Location::where('event_id', $id)->with('floors.rooms')->get();

        return LocationResource::collection($locations);
    }
}
