<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BulletinResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'image' => $this->image !== null ? url(Storage::url($this->image)) : null,
            'published_at' => $this->published_at,
            'links' => json_decode($this->links),
        ];
    }
}
