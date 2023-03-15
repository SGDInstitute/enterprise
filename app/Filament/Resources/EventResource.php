<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Carbon;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                        // $set('slug', Str::slug($stat e));
                    })
                    ->hidden(fn ($record) => $record !== null),
                Card::make([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('subtitle')
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
                    RichEditor::make('description')->columnSpanFull(),
                ])->columns(2),
                Card::make([
                    Repeater::make('tabs')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('slug')->required(),
                        TextInput::make('icon')->required(),
                        RichEditor::make('content')->required()->columnSpanFull(),
                    ])
                    ->columns(3),
                ])->hidden(fn ($record) => $record === null),
                Card::make([
                    FileUpload::make('logo')->preserveFilenames(),
                    FileUpload::make('background')->preserveFilenames(),
                ])->hidden(fn ($record) => $record === null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('subtitle')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('start')
                    ->formatStateUsing(fn ($record) => $record->formattedStart)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('end')
                    ->formatStateUsing(fn ($record) => $record->formattedEnd)
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('timezone')
                    ->formatStateUsing(fn ($record) => $record->formattedTimezone)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
            ])
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'view' => Pages\ViewEvent::route('/{record}'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
