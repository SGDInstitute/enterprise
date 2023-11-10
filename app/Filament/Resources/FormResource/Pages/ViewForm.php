<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Filament\Resources\FormResource\Widgets\FormatChart;
use App\Filament\Resources\FormResource\Widgets\SessionChart;
use App\Filament\Resources\FormResource\Widgets\StatusBreakdown;
use App\Filament\Resources\FormResource\Widgets\TrackBreakdown;
use App\Notifications\ProposalApproved;
use App\Notifications\ProposalRejected;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
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
                ->modalDescription('Are you sure you\'d like to notify these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'approved']))
                ->modalSubmitActionLabel('Yes, notify them')
                ->color('primary')
                ->hidden(fn ($record) => $record->type !== 'workshop'),
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
                ->modalDescription('Are you sure you\'d like to delete these users? This cannot be undone.')
                ->modalContent(view('filament.resources.form-resource.actions.notification-list', ['status' => 'rejected']))
                ->modalSubmitActionLabel('Yes, notify them')
                ->color('danger')
                ->hidden(fn ($record) => $record->type !== 'workshop'),
            Action::make('view_frontend')
                ->outlined()
                ->url(route('app.forms.show', $this->record))
                ->extraAttributes([
                    'target' => '_blank',
                ]),
            EditAction::make()
                ->label('Edit Form')
                ->color('gray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        if ($this->record->type === 'workshop') {
            return [
                StatusBreakdown::class,
                TrackBreakdown::class,
                SessionChart::class,
                FormatChart::class,
            ];
        }

        return [];
    }
}
