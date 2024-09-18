<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResponseResource\Pages\CreateResponse;
use App\Filament\Resources\ResponseResource\Pages\EditResponse;
use App\Filament\Resources\ResponseResource\Pages\ListResponses;
use App\Filament\Resources\ResponseResource\Pages\ReviewResponse;
use App\Filament\Resources\ResponseResource\Pages\ViewResponse;
use App\Models\Response;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email'),
                TextInput::make('type'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns(1)
            ->schema([
                Split::make([
                    Section::make('Answers')
                        ->schema(fn ($record) => [
                            ...$record->form->questions->map(function ($item) {
                                $entry = TextEntry::make("answers.{$item['data']['id']}")
                                    ->label($item['data']['question'])
                                    ->placeholder('was not answered');

                                if ($item['data']) {
                                    $entry->html();
                                }

                                return $entry;
                            }),
                        ])
                        ->grow(),
                    Section::make([
                        TextEntry::make('form.name'),
                        TextEntry::make('type'),
                        TextEntry::make('user.name'),
                        TextEntry::make('collaborators.name')
                            ->listWithLineBreaks()
                            ->bulleted(),
                        TextEntry::make('invitations.name')
                            ->listWithLineBreaks()
                            ->bulleted(),
                        TextEntry::make('status'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
                ])->from('md'),
            ]);
    }

    public static function table(Table $table): Table
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
                TextColumn::make('user.email')
                    ->label('Owner Email')
                    ->copyable()
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
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
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
            'index' => ListResponses::route('/'),
            'create' => CreateResponse::route('/create'),
            'view' => ViewResponse::route('/{record}'),
            'edit' => EditResponse::route('/{record}/edit'),
            'review' => ReviewResponse::route('/{record}/review'),
        ];
    }
}
