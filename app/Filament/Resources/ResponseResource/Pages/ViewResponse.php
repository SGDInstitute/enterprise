<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Actions\StaticAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewResponse extends ViewRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view-rubric')
                ->icon('heroicon-m-table-cells')
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->modalContent(view('filament.resources.response-resource.actions.rubric'))
                ->modalSubmitAction(false)
                ->modalWidth('6xl')
                ->outlined(),
            Action::make('view-tracks')
                ->icon('heroicon-m-rectangle-group')
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->modalContent(view('filament.resources.response-resource.actions.tracks'))
                ->modalSubmitAction(false)
                ->modalWidth('6xl')
                ->outlined(),
            Action::make('view-scores-and-notes')
                ->icon('heroicon-m-sparkles')
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->modalContent(fn () => view('filament.resources.response-resource.actions.scores-n-notes', ['reviews' => $this->record->reviews]))
                ->modalSubmitAction(false)
                ->modalWidth('6xl')
                ->outlined(),
        ];
    }
}
