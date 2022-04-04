<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Multi implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        if ($attributes['type'] === 'array') {
            return json_decode($value, true);
        } else {
            return trim($value, '"');
        }
    }

    public function set($model, $key, $value, $attributes)
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
