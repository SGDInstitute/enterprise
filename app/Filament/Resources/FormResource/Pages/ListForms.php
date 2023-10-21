<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use Filament\Actions\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForms extends ListRecords
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
