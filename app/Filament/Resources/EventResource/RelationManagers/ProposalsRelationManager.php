<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProposalsRelationManager extends RelationManager
{
    protected static string $relationship = 'proposals';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('creator')
                    ->content(fn ($record) => recordLink($record->user, 'users.edit', $record->user->name)),
                Placeholder::make('name')
                    ->content(fn ($record) => $record->name),
                ViewField::make('answers')->view('filament.resources.response-resource.answers')->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Proposal ID')
                    ->searchable(
                        query: fn (Builder $query, string $search): Builder => $query->where('responses.id', 'like', "%{$search}%")
                    )
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
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
            ])
            ->headerActions([
                //
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
