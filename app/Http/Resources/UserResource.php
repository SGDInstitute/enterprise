<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'roles' => $this->roles->pluck('name')->all(),
            'pronouns' => $this->profile->pronouns,
            'sexuality' => $this->profile->sexuality,
            'gender' => $this->profile->gender,
            'race' => $this->profile->race,
            'college' => $this->profile->college,
            'tshirt' => $this->profile->tshirt,
            'accommodation' => $this->profile->accommodation,
            'accessibility' => $this->profile->joinedAccessibility,
            'language' => $this->profile->joinedLanguage,
        ];
    }
}
