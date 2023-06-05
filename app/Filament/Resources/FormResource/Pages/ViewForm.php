<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormResource\Widgets\FormatChart;
use App\Filament\Resources\FormResource\Widgets\SessionChart;
use App\Filament\Resources\FormResource\Widgets\StatusBreakdown;
use App\Filament\Resources\FormResource\Widgets\TrackBreakdown;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected static string $view = 'filament.resources.forms.pages.view-form';

    protected function getActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatusBreakdown::class,
            TrackBreakdown::class,
            SessionChart::class,
            FormatChart::class,
        ];
    }
}
