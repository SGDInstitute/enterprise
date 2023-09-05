<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Models\Form as ModelsForm;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProposalsRelationManager extends RelationManager
{
    protected static string $relationship = 'proposals';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getSiteColumns()
    {
        $uri = request()->getRequestUri();
        if (Str::of($uri)->startsWith('/livewire')) {
            $data = request()->json()->get('serverMemo')['dataMeta']['models'];
            $id = isset($data['record']) ? $data['record']['id'] : $data['ownerRecord']['id'];
        } else {
            $id = explode('/', $uri)[3];
        }
        $form = ModelsForm::where('event_id', $id)->where('type', 'workshop')->first();

        if ($form) {
            return collect($form->settings->searchable)
                ->map(function ($id) {
                    return TextColumn::make('answers.' . $id)
                        ->label(strtoupper($id))
                        ->toggleable();
                });
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('creator')
                    ->content(fn ($record) => filamentLink(UserResource::getUrl('edit', ['record' => $record->user]), $record->user->name)),
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
