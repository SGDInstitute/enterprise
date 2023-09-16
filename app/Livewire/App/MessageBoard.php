<?php

namespace App\Livewire\App;

use App\Models\Event;
use App\Models\Post;
use App\Notifications\PostCreated;
use App\Notifications\SlackNotifiable;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Tags\Tag;

class MessageBoard extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    use WithPagination;

    public Event $event;

    public $perPage = 12;
    public $search = '';
    public $tagsFilter = [];

    public function render()
    {
        return view('livewire.app.message-board')
            ->with([
                'records' => $this->getTableQuery()->paginate($this->perPage),
                'tags' => Tag::withType('posts')->get(),
            ]);
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->form([
                TextInput::make('title')->required(),
                RichEditor::make('content')->required(),
                Select::make('tags')
                    ->options(Tag::getWithType('posts')->pluck('name', 'name'))
                    ->multiple()
                    ->required(),
            ])
            ->action(function ($data) {
                $post = Post::create([
                    'event_id' => $this->event->id,
                    'user_id' => auth()->id(),
                    'title' => $data['title'],
                    'content' => $data['content'],
                ]);

                $post->attachTags($data['tags'], 'posts');

                (new SlackNotifiable())->notify(new PostCreated($this->event, $post));

                Notification::make()
                    ->success()
                    ->title('Created post')
                    ->body('Your post was submitted and will be visible once approved.')
                    ->send();
            });
    }

    public function getTableQuery(): Builder
    {
        return Post::forEvent($this->event)
            ->approved()
            ->when($this->tagsFilter !== [], function ($query) {
                $query->withAllTags($this->tagsFilter, 'posts');
            })
            ->when($this->search, function ($query) {
                $query->where(
                    fn ($query) => $query
                        ->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('content', 'like', '%' . $this->search . '%')
                );
            });
    }
}
