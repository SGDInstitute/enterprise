<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema(fn () => [
                        Card::make([
                            Select::make('preset')
                                ->options([
                                    'mblgtacc' => 'MBLGTACC',
                                    'conference' => 'Conference',
                                    'small' => 'Small event',
                                    'virtual' => 'Virtual',
                                ])
                                ->reactive()
                                ->afterStateUpdated(function (Closure $set, $state) {
                                    if ($state === 'mblgtacc') {
                                        $start = new Carbon('first Friday of October');
                                        $set('name', 'MBLGTACC 20XX');
                                        $set('start', $start->addHours(6));
                                        $set('end', $start->clone()->addDays(2));
                                        $set('order_prefix', 'MBL');
                                        $set('description', 'The Midwest Bisexual Lesbian Gay Transgender Asexual College Conference (MBLGTACC) is an annual conference held to connect, educate, and empower LGBTQIA+ college students, faculty, and staff around the Midwest and beyond. It has attracted advocates and thought leaders including Angela Davis, Robyn Ochs, Janet Mock, Laverne Cox, Kate Bornstein, Faisal Alam, and LZ Granderson; and entertainers and artists including Margaret Cho, J Mase III, Chely Wright, and Loren Cameron.');
                                    }
                                    // $set('slug', Str::slug($state));
                                })
                        ]),
                        Card::make([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('location')
                                ->maxLength(255),
                            TextInput::make('order_prefix')
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
                            Textarea::make('description')->columnSpanFull(),
                        ])->columns(3)->columnSpan(2)
                    ]),
                // Forms\Components\TextInput::make('settings'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('formatted_duration')
                    ->label('Duration'),
                Tables\Columns\TextColumn::make('timezone'),
                Tables\Columns\TextColumn::make('location'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
