<?php

namespace App\Filament\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class MarkAsUnpaidAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'mark-as-unpaid';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->action(function (Model $record): void {
            $record->markAsUnpaid();

            Notification::make()->title('Successfully marked order as unpaid.')->success()->send();
        })
             ->disabled(fn ($record) => $record->isStripe());
    }
}
