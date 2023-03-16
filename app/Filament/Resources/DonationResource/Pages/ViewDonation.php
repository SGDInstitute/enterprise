<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDonation extends ViewRecord
{
    protected static string $resource = DonationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
