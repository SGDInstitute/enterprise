<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'hash' => $this->hash,
            'user' => $this->user_id === null ? null : new UserResource($this->user),
            'type' => $this->ticket_type->name,
            'in_queue' => $this->queue !== null,
            'is_printed' => $this->queue ? $this->queue->completed ? true : false : false,
        ];
    }
}
