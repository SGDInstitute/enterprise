<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class EventItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Schedule';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('speaker')->maxLength(255),
                RichEditor::make('description')->columnSpanFull(),
                Fieldset::make('Duration')
                    ->schema([
                        DateTimePicker::make('start')
                            ->required(),
                        DateTimePicker::make('end')
                            ->required(),
                        TimezoneSelect::make('timezone')
                            ->searchable()
                            ->required(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('duration')
                    ->formatStateUsing(fn ($record) => $record->formattedDuration),
                TextColumn::make('location'),
                TextColumn::make('name'),
                TextColumn::make('tracks'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }    
}
