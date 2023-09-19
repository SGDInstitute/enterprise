<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Event;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_frontend')
                ->modalWidth('sm')
                ->form([
                    Select::make('event')
                        ->options(Event::whereHas('posts')->pluck('name', 'slug'))
                ])
                ->outlined()
                ->action(fn ($data) => redirect()->route('message-board', $data['event'])),
        ];
    }
}
