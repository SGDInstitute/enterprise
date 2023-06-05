<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Filament\Resources\ResponseResource;
use App\Models\Form as ModelsForm;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResponsesRelationManager extends RelationManager
{
    protected static string $relationship = 'responses';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                ...static::getSiteColumns(),
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
                    ->options(fn ($livewire) => collect($livewire->ownerRecord->questions
                        ->firstWhere('data.id', 'track-first-choice')['data']['options'])
                        ->mapWithKeys(function ($option) {
                            $key = explode(':', $option)[0];
                            return [$key => $key];
                        })
                    )
                    ->query(fn ($query, $data) => $query->when($data['value'] !== null, fn ($query) => 
                        $query->where('answers->track-first-choice', $data['value'])
                    )),
                SelectFilter::make('track-second-choice')
                    ->options(fn ($livewire) => collect($livewire->ownerRecord->questions
                        ->firstWhere('data.id', 'track-second-choice')['data']['options'])
                        ->mapWithKeys(function ($option) {
                            $key = explode(':', $option)[0];
                            return [$key => $key];
                        })
                    )
                    ->query(fn ($query, $data) => $query->when($data['value'] !== null, fn ($query) => 
                        $query->where('answers->track-second-choice', $data['value'])
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
                //
            ]);
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }

    private static function getSiteColumns()
    {
        $uri = request()->getRequestUri();
        if (Str::of($uri)->startsWith('/livewire')) {
            $data = request()->json()->get('serverMemo')['dataMeta']['models'];
            $id = isset($data['record']) ? $data['record']['id'] : $data['ownerRecord']['id'];
        } else {
            $id = explode('/', $uri)[3];
        }
        $form = ModelsForm::where('id', $id)->first();

        if ($form) {
            return collect($form->settings->searchable)
                ->map(function ($id) {
                    return TextColumn::make('answers.' . $id)
                        ->label(Str::of($id)->replace('-', ' ')->title())
                        ->action(fn ($livewire, $record) => $livewire->tableFilters[$id] = ['value' => $record->answers[$id]])
                        ->toggleable();
                });
        }
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
}
