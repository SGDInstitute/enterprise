<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Models\Post;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieTagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Actions::make([
                    Action::make('approve')
                        ->action(function ($record) {
                            $record->approve(auth()->user());
                        }),
                    Action::make('delete')
                        ->color('danger')
                        ->action(function ($record) {
                            $record->delete();
                        }),
                ])->columnSpanFull(),
                TextEntry::make('event.name'),
                TextEntry::make('title'),
                TextEntry::make('user.name'),
                TextEntry::make('tags.name'),
                TextEntry::make('content')->columnSpanFull()->prose(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('event.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                SpatieTagsColumn::make('tags')
                    ->type('posts'),
                TextColumn::make('approvedBy.name')
                    ->label('Approved By')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('approved')
                    ->query(fn (Builder $query): Builder => $query->approved()),
                Filter::make('needs-review')
                    ->query(fn (Builder $query): Builder => $query->unapproved()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => ListPosts::route('/'),
        ];
    }
}
