<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ResponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'responses';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reviews_count')
                    ->counts('reviews')
                    ->label('# Reviews')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('reviews_avg_score')
                    ->avg('reviews', 'score')
                    ->label('Avg. Score')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('reviewed')
                    ->label('You Reviewed')
                    ->boolean()
                    ->getStateUsing(fn (Model $record) => $record->reviews->pluck('user_id')->contains(auth()->id()))
                    ->falseIcon('')
                    ->toggleable(),
                TextColumn::make('id')
                    ->label('Proposal ID')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->action(fn ($livewire, $record) => $livewire->tableFilters['user'] = ['value' => $record->user_id])
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('collaborators_count')
                    ->counts('collaborators')
                    ->formatStateUsing(fn ($state) => $state - 1)
                    ->label('# Co-presenters')
                    ->toggleable(),
                TextColumn::make('invitations_count')
                    ->counts('invitations')
                    ->label('# Invitations')
                    ->toggleable(),
                TextColumn::make('status')
                    ->sortable()
                    ->action(fn ($livewire, $record) => $livewire->tableFilters['status'] = ['values' => [$record->status]])
                    ->toggleable(),
                TextColumn::make('name')
                    ->sortable()
                    ->toggleable()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'work-in-progress' => 'Work in Progress',
                        'submitted' => 'Submitted',
                        'in-review' => 'In Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        'scheduled' => 'Scheduled',
                        'canceled' => 'Canceled',
                        'confirmed' => 'Confirmed',
                        'waiting-list' => 'Waiting List',
                    ])
                    ->multiple(),
                SelectFilter::make('user')
                    ->relationship('user', 'email')
                    ->searchable(),
                SelectFilter::make('track-first-choice')
                    ->options(
                        fn ($livewire) => collect($livewire->ownerRecord->questions
                            ->firstWhere('data.id', 'track-first-choice')['data']['options'])
                            ->mapWithKeys(function ($option) {
                                $key = explode(':', $option)[0];

                                return [$key => $key];
                            })
                    )
                    ->query(fn ($query, $data) => $query->when(
                        $data['value'] !== null,
                        fn ($query) => $query->where('answers->track-first-choice', $data['value'])
                    )),
                SelectFilter::make('track-second-choice')
                    ->options(
                        fn ($livewire) => collect($livewire->ownerRecord->questions
                            ->firstWhere('data.id', 'track-second-choice')['data']['options'])
                            ->mapWithKeys(function ($option) {
                                $key = explode(':', $option)[0];

                                return [$key => $key];
                            })
                    )
                    ->query(fn ($query, $data) => $query->when(
                        $data['value'] !== null,
                        fn ($query) => $query->where('answers->track-second-choice', $data['value'])
                    )),
            ])
            ->headerActions([
                //
            ])
            ->actions([
                Action::make('review')
                    ->url(fn ($record) => ResponseResource::getUrl('review', $record)),
            ])
            ->bulkActions([
                BulkAction::make('change_status')
                    ->size('md')
                    ->action(fn (Collection $records, $data) => Response::whereIn('id', $records->pluck('id'))
                        ->update(['status' => $data['status']]))
                    ->form([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'work-in-progress' => 'Work in Progress',
                                'submitted' => 'Submitted',
                                'in-review' => 'In Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                                'waiting-list' => 'Waiting List',
                                'confirmed' => 'Confirmed',
                                'scheduled' => 'Scheduled',
                                'canceled' => 'Canceled',
                            ])
                            ->required(),
                    ])
                    ->deselectRecordsAfterCompletion(),
            ]);
    }

    protected function getTableActionsPosition(): ?string
    {
        return \Filament\Tables\Enums\ActionsPosition::BeforeCells;
    }

    protected function getTableFiltersLayout(): ?string
    {
        return \Filament\Tables\Enums\FiltersLayout::AboveContent;
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }

    protected function shouldPersistTableSortInSession(): bool
    {
        return true;
    }
}
