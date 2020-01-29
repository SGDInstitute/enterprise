<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LocationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'background' => Storage::url($this->background),
            'description' => $this->description,
            'coordinates' => [
                'latitude' => (int) $this->latitude,
                'longitude' => (int) $this->longitude,
            ],
            'floors' => FloorResource::collection($this->whenLoaded('floors')),
        ];
    }
}
