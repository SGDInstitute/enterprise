<?php

namespace App\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class StatusBreakdown extends Widget
{
    protected static string $view = 'filament.resources.form-resource.widgets.status-breakdown';
    public ?Model $record = null;

    protected function getViewData(): array
    {
        return [
            'data' => $this->record->responses->countBy('status'),
        ];
    }
}
