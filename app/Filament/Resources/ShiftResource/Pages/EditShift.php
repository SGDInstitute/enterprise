<?php

namespace App\Filament\Resources\ShiftResource\Pages;

use App\Filament\Resources\ShiftResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;

class EditShift extends EditRecord
{
    protected static string $resource = ShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['start'] = Carbon::parse($data['start'], 'UTC')->timezone($data['timezone'])->toDateTimeString();
        $data['end'] = Carbon::parse($data['end'], 'UTC')->timezone($data['timezone'])->toDateTimeString();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
        $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');

        return $data;
    }
}
