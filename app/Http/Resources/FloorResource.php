<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FloorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'floor_plan' => url(Storage::url($this->floor_plan)),
            'level' => $this->level,
            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
        ];
    }
}
