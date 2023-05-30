<?php

namespace App\Filament\Resources\FormResource\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;

class TrackBreakdown extends Widget
{
    public ?Model $record = null;

    protected static string $view = 'filament.resources.form-resource.widgets.track-breakdown';

    protected function getViewData(): array
    {
        $responses = $this->record->responses()->where('status', '<>', 'work-in-progress')->get();
        $first = $responses->countBy('answers.track-first-choice');
        $second = $responses->countBy('answers.track-second-choice');

        return [
            'data' => $first->map(fn ($count, $key) => [$count, $second[$key] ?? 0]),
        ];
    }
}
