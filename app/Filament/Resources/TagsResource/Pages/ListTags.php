<?php

namespace App\Filament\Resources\TagsResource\Pages;

use App\Filament\Resources\TagsResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\Tag;

class ListTags extends ListRecords
{
    protected static string $resource = TagsResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data): Model {
                    return Tag::findOrCreate($data['name'], $data['type']);
                }),
        ];
    }
}
