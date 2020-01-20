<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'owner_id' => $this->user_id,
            'is_paid' => $this->confirmation_number !== null,
            'confirmation_number' => $this->confirmation_number,
            'amount' => $this->amount,
            'tickets' => $this->tickets
        ];
    }
}
