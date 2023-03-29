<?php

namespace App\Filament\Resources\TicketTypeResource\Pages;

use App\Filament\Resources\TicketTypeResource;
use App\Models\Event;
use App\Models\TicketType;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreateTicketType extends CreateRecord
{
    protected static string $resource = TicketTypeResource::class;

    protected function afterFill(): void
    {
        if ($eventId = request('event_id')) {
            $this->data['event_id'] = $eventId;
        }
    }

    protected function handleRecordCreation(array $data): Model
    {
        if ($data['structure'] === 'flat') {
            $event = Event::find($data['event_id']);

            return TicketType::createFlatWithStripe([
                'event_id' => $event->id,
                'timezone' => $timezone = $event->timezone,
                'name' => $data['name'],
                'start' => Carbon::parse($data['start'], $timezone)->timezone('UTC'),
                'end' => Carbon::parse($data['end'], $timezone)->timezone('UTC'),
            ], $data['cost'] * 100);
        } elseif ($data['structure' === 'scaled-range']) {
            // @todo
        }
    }
}
