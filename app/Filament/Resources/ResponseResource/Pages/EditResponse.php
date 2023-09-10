<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Pages\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Tables\Actions\DeleteAction;

class EditResponse extends EditRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
