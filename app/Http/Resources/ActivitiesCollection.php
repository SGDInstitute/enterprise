<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ActivitiesCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => new ActivitiesResource($this->collection),
            'count' => $this->collection->count(),
            'timestamp' => now(),
        ];
    }
}
