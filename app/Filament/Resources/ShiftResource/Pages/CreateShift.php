<?php

namespace App\Filament\Resources\ShiftResource\Pages;

use App\Filament\Resources\ShiftResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Carbon;

class CreateShift extends CreateRecord
{
    protected static string $resource = ShiftResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
        $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');

        return $data;
    }
}
