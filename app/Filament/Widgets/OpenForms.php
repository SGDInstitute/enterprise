<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\FormResource;
use App\Models\Form;
use Closure;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class OpenForms extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Form::where('start', '<', now())->where('end', '>', now());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->url(fn ($record) => FormResource::getUrl('edit', $record)),
            TextColumn::make('days_left'),
            TextColumn::make('responses_count')->counts('responses')->label('# Responses'),
        ];
    }
}
