<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'schedule' => $this->schedule,
            'title' => $this->title,
            'speakers' => SpeakersResource::collection($this->speakers),
            'description' => $this->description,
            'type' => $this->type->title,
            'color' => $this->type->color,
            'text_color' => $this->type->text_color,
            'location' => $this->location,
            'start' => $this->start->tz($this->timezone)->format('Y-m-d H:i'),
            'start_time' => $this->start->tz($this->timezone)->format('g:i a'),
            'end' => $this->end->tz($this->timezone)->format('Y-m-d H:i'),
            'end_time' => $this->end->tz($this->timezone)->format('g:i a'),
            'workshops' => $this->when($this->type->title === 'group', $this->workshops),
        ];
    }
}
