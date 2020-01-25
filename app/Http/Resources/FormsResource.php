<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'start' => $this->start->tz('America/Detroit')->format('Y-m-d H:i'),
            'end' => $this->end->tz('America/Detroit')->format('Y-m-d H:i'),
            'form' => $this->form,
        ];
    }
}
