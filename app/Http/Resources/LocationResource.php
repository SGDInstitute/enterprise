<?php

namespace App\Http\Resources;

use App\Models\ActivityType;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LocationResource extends JsonResource
{
    public function toArray($request)
    {
        $type = ActivityType::where('title', $this->type)->first();

        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'background' => url(Storage::url($this->background)),
            'description' => $this->description,
            'coordinates' => [
                'latitude' => (float) $this->latitude,
                'longitude' => (float) $this->longitude,
            ],
            'color' => $type->color ?? '#009999',
            'text_color' => $type->text_color ?? '#ffffff',
            'floors' => FloorResource::collection($this->whenLoaded('floors')),
        ];
    }
}
