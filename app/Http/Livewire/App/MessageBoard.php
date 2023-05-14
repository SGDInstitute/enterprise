<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use App\Models\Thread;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MessageBoard extends Component implements HasTable
{
    use InteractsWithTable;

    public Event $event;

    public function render()
    {
        return view('livewire.app.message-board');
    }

    protected function getTableQuery(): Builder 
    {
        return Thread::forEvent($this->event);
    }

    protected function getTableColumns(): array 
    {
        return [ 
            TextColumn::make('title')->searchable(),
            TextColumn::make('user.name')->searchable(),
            TextColumn::make('created_at')->dateTime(),
            TagsColumn::make('tags'),
        ]; 
    }
 
    protected function getTableFilters(): array
    {
        return [ 
            Filter::make('published')
                ->query(fn (Builder $query): Builder => $query->where('is_published', true)),
            SelectFilter::make('status')
                ->options([
                    'draft' => 'Draft',
                    'in_review' => 'In Review',
                    'approved' => 'Approved',
                ]),
        ]; 
    }

    protected function getTableActions(): array
    {
        return [ 
            ViewAction::make()
                ->url(fn (Thread $record) => route('threads.show', [$this->event, $record])),
            EditAction::make()
                ->url(fn (Thread $record) => route('threads.edit', [$this->event, $record])),
        ]; 
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->url(route('threads.create', $this->event)),
        ];
    }

    protected function getTableHeading(): string
    {
        return 'Message Board';
    }
}
