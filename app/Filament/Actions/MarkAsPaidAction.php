<?php

namespace App\Filament\Actions;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MarkAsPaidAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'mark-as-paid';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->form([
            Placeholder::make('order_id')
                ->label('Order ID')
                ->content(fn ($record) => $record->id),
            TextInput::make('check_number')->required(),
            TextInput::make('amount')
                ->prefix('$')
                ->mask(RawJs::make(<<<'JS'
                    $money($input)
                JS))
                ->required(),
        ])
            ->action(function (Model $record, array $data): void {
                $record->markAsPaid(
                    Str::start($data['check_number'], '#'),
                    $data['amount'] * 100
                );

                Notification::make()->title('Successfully marked order as paid.')->success()->send();
            });
    }
}
