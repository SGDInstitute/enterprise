<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('event_id'),
                TextInput::make('parent_id'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                Toggle::make('auth_required')
                    ->required(),
                Toggle::make('is_internal')
                    ->required(),
                TextInput::make('list_id')
                    ->maxLength(255),
                DateTimePicker::make('start'),
                DateTimePicker::make('end'),
                TextInput::make('timezone')
                    ->maxLength(255),
                TextInput::make('form'),
                TextInput::make('settings'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('auth_required')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_internal')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('responses')
                    ->formatStateUsing(fn ($state) => count($state))
                    ->label('# Responses'),
                TextColumn::make('start')
                    ->formatStateUsing(fn ($record) => $record->formattedStart)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('end')
                    ->formatStateUsing(fn ($record) => $record->formattedEnd)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('timezone')
                    ->formatStateUsing(fn ($record) => $record->formattedTimezone)
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('start', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'view' => Pages\ViewForm::route('/{record}'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
