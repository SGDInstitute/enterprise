<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\ResponseResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ProposalsRelationManager extends RelationManager
{
    protected static string $relationship = 'proposals';

    protected static ?string $recordTitleAttribute = 'name';

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
                ViewAction::make()
                    ->url(fn ($record) => ResponseResource::getUrl('view', ['record' => $record])),
            ])
            ->bulkActions([
                //
            ]);
    }
}
