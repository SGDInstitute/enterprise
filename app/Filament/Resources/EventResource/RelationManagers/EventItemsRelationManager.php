<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\EventItem;
use App\Models\Response;
use App\Notifications\WorkshopScheduled;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
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
                Select::make('parent_id')
                    ->label('Parent')
                    ->live()
                    ->relationship(
                        name: 'parent',
                        modifyQueryUsing: fn (Builder $query) => $query->whereNull('parent_id')->where('event_id', $this->ownerRecord->id),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->start->format('D')})")
                    ->searchable(),
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('speaker')->maxLength(255),
                TextInput::make('location')->maxLength(255),
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
                    ->columns(3)
                    ->hidden(fn (Get $get): bool => $get('parent_id') !== null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formattedDuration')
                    ->label('Duration')
                    ->sortable(['start']),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tracks'),
            ])
            ->filters([
                Filter::make('is_parent')
                    ->query(fn (Builder $query): Builder => $query->whereNull('parent_id')),
            ])
            ->headerActions([
                Action::make('export-copyable-schedule')
                    ->label('Export (txt)')
                    ->action(function () {
                        $parents = $this->ownerRecord->items()->whereNull('parent_id')->orderBy('start')->with('children')->get();
                        $contents = view('exports.copyable-schedule', ['items' => $parents])->render();

                        $date = now()->format('Y-m-d');

                        return response()->streamDownload(
                            fn () => print($contents),
                            "schedule-export-{$date}.txt"
                        );
                    }),
                ActionGroup::make([
                    CreateAction::make()
                        ->mutateFormDataUsing(function (array $data): array {
                            if ($data['parent_id'] !== null) {
                                $parent = EventItem::find($data['parent_id']);
                                $data['start'] = $parent->start;
                                $data['end'] = $parent->end;
                                $data['timezone'] = $parent->timezone;
                            } else {
                                $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
                                $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');
                            }

                            return $data;
                        }),
                    Action::make('create-sub')
                        ->label('Link Item')
                        ->form([
                            Select::make('parent_id')
                                ->label('Parent')
                                ->relationship(
                                    name: 'parent',
                                    modifyQueryUsing: fn (Builder $query) => $query->whereNull('parent_id')->where('event_id', $this->ownerRecord->id),
                                )
                                ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->name} ({$record->start->format('D')})")
                                ->searchable(),
                            Select::make('workshop_id')
                                ->label('Proposal')
                                ->options($this->ownerRecord->proposals()->where('status', 'confirmed')->get()->pluck('name', 'id')),
                            TextInput::make('location'),
                            Select::make('track')
                                ->options(collect($this->ownerRecord->settings->tracks)->pluck('name', 'id')),
                        ])
                        ->action(function (array $data): void {
                            $parent = EventItem::find($data['parent_id']);
                            $workshop = Response::find($data['workshop_id']);

                            $item = EventItem::create([
                                'event_id' => $parent->event_id,
                                'parent_id' => $parent->id,
                                'name' => $workshop->name,
                                'description' => $workshop->description,
                                'start' => $parent->start,
                                'end' => $parent->end,
                                'timezone' => $parent->timezone,
                                'location' => $data['location'],
                                'settings' => ['workshop_id' => $workshop->id],
                                'speaker' => $workshop->collaborators->map(fn ($user) => $user->formattedName)->join(', '),
                            ]);

                            $workshop->update(['status' => 'scheduled']);
                            Notification::send($workshop->collaborators, new WorkshopScheduled($workshop, $item));
                        }),
                ]),
            ])
            ->actions([
                EditAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['start'] = Carbon::parse($data['start'], 'UTC')->timezone($data['timezone'])->toDateTimeString();
                        $data['end'] = Carbon::parse($data['end'], 'UTC')->timezone($data['timezone'])->toDateTimeString();

                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        if ($data['parent_id'] !== null) {
                            $parent = EventItem::find($data['parent_id']);
                            $data['start'] = $parent->start;
                            $data['end'] = $parent->end;
                            $data['timezone'] = $parent->timezone;
                        } else {
                            $data['start'] = Carbon::parse($data['start'], $data['timezone'])->timezone('UTC');
                            $data['end'] = Carbon::parse($data['end'], $data['timezone'])->timezone('UTC');
                        }

                        return $data;
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
