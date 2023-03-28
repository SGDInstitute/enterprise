<?php

namespace App\Filament\Resources\TicketTypeResource\Pages;

use App\Filament\Resources\TicketTypeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTicketType extends CreateRecord
{
    protected static string $resource = TicketTypeResource::class;

    protected function afterFill(): void
    {
        if ($eventId = request('event_id')) {
            $this->data['eventId'] = $eventId;
        }
    }
}
