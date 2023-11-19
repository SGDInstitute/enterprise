<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages\CreateEvent;
use App\Filament\Resources\EventResource\Pages\EditEvent;
use App\Filament\Resources\EventResource\Pages\ListEvents;
use App\Filament\Resources\EventResource\Pages\ReportEvent;
use App\Filament\Resources\EventResource\RelationManagers\EventItemsRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\OrdersRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\ProposalsRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\ReservationsRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\TicketsRelationManager;
use App\Filament\Resources\EventResource\RelationManagers\TicketTypesRelationManager;
use App\Models\Event;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Tapp\FilamentTimezoneField\Forms\Components\TimezoneSelect;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

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
                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                        self::setUpPreset($set, $state);
                    })
                    ->hidden(fn ($record) => $record !== null),
                Tabs::make('Heading')
                    ->tabs([
                        Tab::make('Information')->schema([
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
                        Tab::make('Policy Tabs')->schema([
                            Repeater::make('settings.tabs')
                                ->schema([
                                    TextInput::make('name')->required(),
                                    TextInput::make('slug')->required(),
                                    TextInput::make('icon')->required(),
                                    RichEditor::make('content')->required()->columnSpanFull(),
                                ])
                                ->collapsible()
                                ->collapsed()
                                ->cloneable()
                                ->columns(3),
                        ])->hidden(fn ($record) => $record === null),
                        Tab::make('Media')->schema([
                            SpatieMediaLibraryFileUpload::make('logo')->collection('logo')->preserveFilenames(),
                            SpatieMediaLibraryFileUpload::make('background')->collection('background')->preserveFilenames(),
                            SpatieMediaLibraryFileUpload::make('name_badge')->collection('name_badge')->preserveFilenames(),
                        ])->hidden(fn ($record) => $record === null),
                        Tab::make('Tickets')->schema([
                            Checkbox::make('settings.reservations')
                                ->label('Enable reservations')
                                ->hint('This allows a user to not pay right away but reserve tickets to pay another time')
                                ->reactive(),
                            TextInput::make('settings.reservation_length')
                                ->hidden(fn ($get) => ! $get('settings.reservations'))
                                ->hint('How many days does a reservation have to be paid')
                                ->label('Reservation Length'),
                            Checkbox::make('settings.volunteer_discounts')
                                ->label('Enable volunteer discounts'),
                            Checkbox::make('settings.presenter_discounts')
                                ->label('Enable presenter discounts'),
                            Checkbox::make('settings.demographics')
                                ->label('Collect demographics'),
                            Checkbox::make('settings.add_ons')
                                ->label('Enable Add on options')
                                ->hint('These are extra cost items that can be added to a ticket e.g. meal tickets, t-shirts.'),
                            Checkbox::make('settings.bulk')
                                ->label('Allow bulk orders'),
                            Checkbox::make('settings.invoices')
                                ->label('Enable invoice generation'),
                            Checkbox::make('settings.check_payment')
                                ->label('Allow pay by check')
                                ->hint('If unchecked the event can only be paid for by credit card.'),
                            Checkbox::make('settings.onsite')
                                ->label('On-site check-in'),
                            Checkbox::make('settings.livestream')
                                ->label('Enable livestream portal'),
                        ]),
                        Tab::make('Workshop/Volunteers')->schema([
                            Checkbox::make('settings.has_workshops')->label('Has workshop proposals'),
                            Placeholder::make('workshop-form')
                                ->content(function ($record) {
                                    if ($record->has('workshopForm')) {
                                        return recordLink($record->workshopForm, 'forms.edit', 'Edit Form');
                                    }

                                    return filamentLink(route('filament.admin.resources.forms.create'), 'Create Form');
                                })
                                ->hidden(fn ($record) => $record === null || ! $record->settings->has_workshops),
                            Checkbox::make('settings.has_tracks')->label('Has workshop tracks')->reactive(),
                            Repeater::make('settings.tracks')->label('Tracks')
                                ->collapsible()
                                ->collapsed()
                                ->cloneable()
                                ->columns(3)
                                ->hidden(fn ($get) => ! $get('settings.has_tracks'))
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                ->schema([
                                    TextInput::make('id')->label('ID')->required(),
                                    TextInput::make('name')->required(),
                                    // @todo dynamically add rooms from schedule builder
                                    Select::make('room')->options([]),
                                    RichEditor::make('description')->columnSpanFull()->required(),
                                ]),
                            Checkbox::make('settings.has_volunteers')->label('Has volunteers'),
                        ]),
                        Tab::make('Fundraising')->schema([
                            Checkbox::make('settings.has_sponsorship')->label('Has sponsorship packages'),
                            Checkbox::make('settings.has_vendors')->label('Has vendor tables'),
                            Checkbox::make('settings.has_ads')->label('Has program ads'),
                            Checkbox::make('settings.allow_donations')->label('Allow one-time donations'),
                        ]),
                    ])
                    ->columnSpanFull(),
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
            ->defaultSort('start', 'desc')
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ReservationsRelationManager::class,
            OrdersRelationManager::class,
            TicketsRelationManager::class,
            ProposalsRelationManager::class,
            EventItemsRelationManager::class,
            TicketTypesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
            'report' => ReportEvent::route('/{record}/report'),
        ];
    }

    private static function setUpPreset($set, $preset)
    {
        if ($preset === 'mblgtacc') {
            $start = new Carbon('first Friday of October');
            $set('name', 'MBLGTACC 20XX');
            $set('start', $start->addHours(6));
            $set('end', $start->clone()->addDays(2));
            $set('order_prefix', 'MBL');
            $set('description', 'The Midwest Bisexual Lesbian Gay Transgender Asexual College Conference (MBLGTACC) is an annual conference held to connect, educate, and empower LGBTQIA+ college students, faculty, and staff around the Midwest and beyond. It has attracted advocates and thought leaders including Angela Davis, Robyn Ochs, Janet Mock, Laverne Cox, Kate Bornstein, Faisal Alam, and LZ Granderson; and entertainers and artists including Margaret Cho, J Mase III, Chely Wright, and Loren Cameron.');
        }
        if ($preset === 'mblgtacc' || $preset === 'conference') {
            $set('settings.reservations', true);
            $set('settings.volunteer_discounts', true);
            $set('settings.presenter_discounts', true);
            $set('settings.demographics', true);
            $set('settings.add_ons', true);
            $set('settings.bulk', true);
            $set('settings.invoices', true);
            $set('settings.check_payment', true);
            $set('settings.onsite', true);
            $set('settings.livestream', false);
            $set('settings.has_workshops', true);
            $set('settings.has_volunteers', true);
            $set('settings.has_sponsorship', true);
            $set('settings.has_vendors', true);
            $set('settings.has_ads', true);
            $set('settings.allow_donations', true);
        }
        if ($preset === 'small') {
            $set('settings.reservations', true);
            $set('settings.volunteer_discounts', true);
            $set('settings.presenter_discounts', true);
            $set('settings.demographics', true);
            $set('settings.add_ons', true);
            $set('settings.bulk', true);
            $set('settings.invoices', true);
            $set('settings.check_payment', true);
            $set('settings.onsite', true);
            $set('settings.livestream', true);
            $set('settings.has_workshops', false);
            $set('settings.has_volunteers', true);
            $set('settings.has_sponsorship', true);
            $set('settings.has_vendors', false);
            $set('settings.has_ads', false);
            $set('settings.allow_donations', true);
        }
        if ($preset === 'virtual') {
            $set('settings.reservations', false);
            $set('settings.volunteer_discounts', false);
            $set('settings.presenter_discounts', false);
            $set('settings.demographics', true);
            $set('settings.add_ons', false);
            $set('settings.bulk', false);
            $set('settings.invoices', false);
            $set('settings.check_payment', false);
            $set('settings.onsite', false);
            $set('settings.livestream', true);
            $set('settings.has_workshops', false);
            $set('settings.has_volunteers', false);
            $set('settings.has_sponsorship', false);
            $set('settings.has_vendors', false);
            $set('settings.has_ads', false);
            $set('settings.allow_donations', true);
        }
    }
}
