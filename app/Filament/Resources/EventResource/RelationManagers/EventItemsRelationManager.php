<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class EventItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Schedule';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('duration')
                    ->searchable()
                    ->sortable('start')
                    ->formatStateUsing(fn ($record) => $record->formattedDuration),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tracks'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
                        $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');

                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['start'] = Carbon::parse($data['start'], 'UTC')->timezone($data['timezone'])->toDateTimeString();
                        $data['end'] = Carbon::parse($data['end'], 'UTC')->timezone($data['timezone'])->toDateTimeString();

                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
                        $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');

                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
