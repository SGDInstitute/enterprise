<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'form' => [
                'id' => $this->form->id,
                'name' => $this->form->name,
            ],
            'email' => $this->email,
            'response' => $this->responses,
        ];
    }
}
