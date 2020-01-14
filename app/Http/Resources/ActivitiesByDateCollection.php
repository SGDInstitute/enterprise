<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivitiesByDateCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'date' => $this->collection->first()->start->format('Y-m-d'),
            'data' => ActivitiesResource::collection($this->collection),
        ];
    }
}
