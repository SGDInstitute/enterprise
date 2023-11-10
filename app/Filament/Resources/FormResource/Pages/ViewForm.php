<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormResource\Widgets\FormatChart;
use App\Filament\Resources\FormResource\Widgets\SessionChart;
use App\Filament\Resources\FormResource\Widgets\StatusBreakdown;
use App\Filament\Resources\FormResource\Widgets\TrackBreakdown;
use App\Notifications\ProposalApproved;
use App\Notifications\ProposalRejected;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Cache;

class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('notify_approved')
                ->action(function () {
                    $proposals = $this->record->responses()->where('status', 'approved')->get();
                    foreach ($proposals as $response) {
                        $response->user->notify(new ProposalApproved($response));
                    }

                    Cache::forever('notify_approved_' . $this->record->id, true);
                })
                ->disabled(fn () => Cache::has('notify_approved_' . $this->record->id))
                ->modalHeading('Notify users of Approved Presentations')
                ->modalSubheading('Are you sure you\'d like to notify these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'approved']))
                ->modalButton('Yes, notify them')
                ->color('primary'),
            Action::make('notify_rejected')
                ->action(function () {
                    $proposals = $this->record->responses()->where('status', 'rejected')->get();
                    foreach ($proposals as $response) {
                        $response->user->notify(new ProposalRejected($response));
                    }

                    Cache::forever('notify_rejected_' . $this->record->id, true);
                })
                ->disabled(fn () => Cache::has('notify_rejected_' . $this->record->id))
                ->modalHeading('Notify users of Rejected Presentations')
                ->modalSubheading('Are you sure you\'d like to delete these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'rejected']))
                ->modalButton('Yes, notify them')
                ->color('danger'),
            EditAction::make()
                ->label('Edit Form')
                ->color('gray'),
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
