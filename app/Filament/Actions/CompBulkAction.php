<?php

namespace App\Filament\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class CompBulkAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'comp-reservation';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Comp reservations')
            ->action(function (Collection $records): void {
                $count = count($records);
                $records->each(fn ($order) => $order->markAsPaid('comped', 0));

                Notification::make()->title('Successfully marked ' . $count . ' reservations as comped.')->success()->send();
            })
            ->deselectRecordsAfterCompletion();
    }
}
