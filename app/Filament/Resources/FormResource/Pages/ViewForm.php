<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormResource\Widgets\FormatChart;
use App\Filament\Resources\FormResource\Widgets\SessionChart;
use App\Filament\Resources\FormResource\Widgets\StatusBreakdown;
use App\Filament\Resources\FormResource\Widgets\TrackBreakdown;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected static string $view = 'filament.resources.forms.pages.view-form';

    protected function getActions(): array
    {
        return [
            Action::make('notify_approved')
                ->action(fn () => dd('hi'))
                ->modalHeading('Notify users of Approved Presentations')
                ->modalSubheading('Are you sure you\'d like to notify these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'approved']))
                ->modalButton('Yes, notify them')
                ->color('primary'),
            Action::make('notify_rejected')
                ->action(fn () => dd('bye'))
                ->modalHeading('Notify users of Rejected Presentations')
                ->modalSubheading('Are you sure you\'d like to delete these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'rejected']))
                ->modalButton('Yes, notify them')
                ->color('danger'),
            EditAction::make()
                ->label('Edit Form')
                ->color('secondary'),
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
