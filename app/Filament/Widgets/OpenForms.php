<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\FormResource;
use App\Models\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OpenForms extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Form::where('start', '<', now())->where('end', '>', now()))
            ->columns([
                TextColumn::make('name')
                    ->url(fn ($record) => FormResource::getUrl('edit', ['record' => $record])),
                TextColumn::make('days_left'),
                TextColumn::make('responses_count')->counts('responses')->label('# Responses'),
            ]);
    }
}
