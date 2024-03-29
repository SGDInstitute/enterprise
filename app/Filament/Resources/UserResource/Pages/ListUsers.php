<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('mass-delete-junk')
                ->action(function () {
                    User::query()
                        ->whereNull('email_verified_at')
                        ->whereDoesntHave('donations')
                        ->whereDoesntHave('orders', function (Builder $query) {
                            $query->withTrashed();
                        })
                        ->whereDoesntHave('responseOwner')
                        ->whereDoesntHave('responses')
                        ->whereDoesntHave('schedule')
                        ->whereDoesntHave('tickets', function (Builder $query) {
                            $query->withTrashed();
                        })
                        ->delete();
                }),
        ];
    }
}
