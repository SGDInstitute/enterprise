<?php

namespace App\Http\Livewire\App\MessageBoard\Post;

use App\Models\Event;
use App\Models\Post;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use Spatie\Tags\Tag;

class Create extends Component implements HasForms
{
    use InteractsWithForms;

    public Event $event;

    public $title;
    public $content;
    public $tags = [];

    public function render()
    {
        return view('livewire.app.message-board.post.create');
    }

    public function submit()
    {
        // validate
        $data = $this->form->getState();
        $post = Post::create([
            'event_id' => $this->event->id,
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        $post->attachTags($this->tags, 'posts');

        return redirect()->route('posts.show', [$this->event, $post]);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            RichEditor::make('content')
                ->disableToolbarButtons([
                    'attachFiles',
                    'codeBlock',
                ])
                ->required(),
            Select::make('tags')
                ->options(Tag::getWithType('posts')->pluck('name', 'name'))
                ->multiple()
                ->required(),
        ];
    }
}
