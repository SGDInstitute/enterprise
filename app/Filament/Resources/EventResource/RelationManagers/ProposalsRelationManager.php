<?php

namespace App\Filament\Resources\EventResource\RelationManagers;

use App\Models\Form as ModelsForm;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProposalsRelationManager extends RelationManager
{
    protected static string $relationship = 'proposals';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Proposal ID')
                    ->searchable(query: fn (Builder $query, string $search): Builder => 
                        $query->where('responses.id', 'like', "%{$search}%")
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
                //
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

        // return app(ModelsForm::class)
        //     ->query(fn($query) => $query->whereViewableBy(auth()->user()))
        //     ->get()
        //     ->map(function ($site) {
        //         return TextColumn::make($site->slug)
        //             ->label(strtoupper($site->slug))
        //             ->getStateUsing(function ($record) use ($site) {
        //                 return (string) data_get($record, "user_counts.{$site->slug}", '0');
        //             })->toggleable();
        //     })
        //     ->toArray();
    }
}
