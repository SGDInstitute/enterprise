<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Models\Bulletin;
use App\Http\Controllers\Controller;
use App\Http\Resources\BulletinResource;

class EventsBulletinsController extends Controller
{
    public function index($event)
    {
        $bulletins = Bulletin::where('event_id', $event)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();

        return BulletinResource::collection($bulletins);
    }
}
