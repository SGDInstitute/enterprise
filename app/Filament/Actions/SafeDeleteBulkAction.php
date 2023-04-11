<?php

namespace App\Filament\Actions;

use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class SafeDeleteBulkAction extends BulkAction
{
    public static function getDefaultName(): ?string
    {
        return 'safe-delete-bulk';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Bulk Delete')
            ->action(function (Collection $records): void {
                $count = count($records);
                $records->each(fn ($record) => $record->safeDelete());

                Notification::make()->title('Safely deleted ' . $count . ' records.')->success()->send();
            })
            ->requiresConfirmation()
            ->deselectRecordsAfterCompletion();
    }
}
