<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketTypeResource\Pages\CreateTicketType;
use App\Filament\Resources\TicketTypeResource\Pages\EditTicketType;
use App\Filament\Resources\TicketTypeResource\Pages\ListTicketTypes;
use App\Models\TicketType;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class TicketTypeResource extends Resource
{
    protected static ?string $model = TicketType::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function columns(): array
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('structure'),
            TextColumn::make('price_range'),
            TextColumn::make('start')->date(),
            TextColumn::make('end')->date(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    Select::make('event_id')
                        ->relationship('event', 'name'),
                    Select::make('structure')
                        ->options([
                            'flat' => 'Flat',
                            'scaled-range' => 'Sliding Scale',
                        ])
                        ->reactive()
                        ->required(),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('description')
                        ->maxLength(255),
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
                    TextInput::make('cost') // only show when structure is flat
                        ->hidden(fn (\Filament\Forms\Get $get) => $get('structure') !== 'flat')
                        ->mask(RawJs::make(<<<'JS'
                            $money($input)
                        JS)),
                    // @todo scaled range
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::columns())
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTicketTypes::route('/'),
            'create' => CreateTicketType::route('/create'),
            'edit' => EditTicketType::route('/{record}/edit'),
        ];
    }
}
