<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShiftResource\Pages;
use App\Filament\Resources\ShiftResource\RelationManagers\UsersRelationManager;
use App\Models\Event;
use App\Models\Shift;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Select::make('event_id')
                        ->relationship('event', 'name')
                        ->live()
                        ->afterStateUpdated(function (Set $set, $state) {
                            $event = Event::find($state);
                            $set('start', $event->start->timezone($event->timezone)->toDateTimeString());
                            $set('end', $event->end->timezone($event->timezone)->toDateTimeString());
                            $set('timezone', $event->timezone);
                        }),
                    TextInput::make('name')->required()->maxLength(255),
                    TextInput::make('slots')->required()->numeric(),
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
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('formattedDuration')
                    ->label('Duration')
                    ->sortable(['start']),
                TextColumn::make('slots')
                    ->sortable(),
                TextColumn::make('users_count')
                    ->label('Filled Users')
                    ->counts('users')
                    ->sortable(),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    ReplicateAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShifts::route('/'),
            'create' => Pages\CreateShift::route('/create'),
            'edit' => Pages\EditShift::route('/{record}/edit'),
        ];
    }
}
