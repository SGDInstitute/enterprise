<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewForm extends ViewRecord
{
    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
