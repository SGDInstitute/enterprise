<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewResponse extends ViewRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
