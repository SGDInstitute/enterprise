<?php

namespace App\Filament\Resources\TicketTypeResource\Pages;

use App\Filament\Resources\TicketTypeResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class EditTicketType extends EditRecord
{
    protected static string $resource = TicketTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['start'] = Carbon::parse($data['start'])->timezone($this->record->timezone)->toDateTimeString();
        $data['end'] = Carbon::parse($data['end'])->timezone($this->record->timezone)->toDateTimeString();

        if ($data['structure'] === 'flat') {
            $data['cost'] = $this->record->prices->first()->costInDollars;
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['start'] = Carbon::parse($data['start'], $record->timezone)->timezone('UTC');
        $data['end'] = Carbon::parse($data['end'], $record->timezone)->timezone('UTC');
        $record->update(Arr::except($data, 'cost'));

        if ($record->structure === 'flat') {
            $record->prices->first()->update(['cost' => $data['cost'] * 100]);
        }

        return $record;
    }
}
