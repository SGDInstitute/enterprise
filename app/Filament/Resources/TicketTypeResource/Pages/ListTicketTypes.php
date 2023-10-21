<?php

namespace App\Filament\Resources\TicketTypeResource\Pages;

use App\Filament\Resources\TicketTypeResource;
use Filament\Actions\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTicketTypes extends ListRecords
{
    protected static string $resource = TicketTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
