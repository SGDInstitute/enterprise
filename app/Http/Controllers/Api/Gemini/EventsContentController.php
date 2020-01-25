<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Content;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;

class EventsContentController extends Controller
{

    public function index($id)
    {
        $content = Content::where('event_id', $id)
            ->when(request()->query('type'), function ($query, $type) {
                return $query->where('type', $type);
            })
            ->with('event')
            ->get();

        return ContentResource::collection($content);
    }
}
