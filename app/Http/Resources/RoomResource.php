<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'number' => $this->number,
            'name' => $this->name,
        ];
    }
}
