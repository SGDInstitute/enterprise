<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class Multi implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes)
    {
        if ($attributes['type'] === 'array') {
            return json_decode($value, true);
        } else {
            return trim($value, '"');
        }
    }

    public function set(Model $model, string $key, mixed $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        } elseif (is_string($value)) {
            return $value;
        } else {
            return json_encode($value);
        }
    }
}
