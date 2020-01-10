<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schedule' => $this->schedule,
            'title' => $this->title,
            'speaker' => $this->speaker,
            'description' => $this->description,
            'type' => $this->type->title,
            'location' => $this->location,
            'start' => $this->start,
            'end' => $this->end,
        ];
    }
}
