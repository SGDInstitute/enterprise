<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event' => $this->event->title,
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
