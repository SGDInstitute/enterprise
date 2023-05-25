<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponse extends EditRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
