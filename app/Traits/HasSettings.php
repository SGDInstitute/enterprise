<?php

namespace App\Traits;

use Spatie\SchemalessAttributes\SchemalessAttributes;
use Illuminate\Database\Eloquent\Builder;

trait HasSettings {

    public function getSettingsAttribute() : SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'settings');
    }

    public function scopeWithSettings() : Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('settings');
    }

}
