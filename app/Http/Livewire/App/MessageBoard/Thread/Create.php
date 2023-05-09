<?php

namespace App\Http\Livewire\App\MessageBoard\Thread;

use App\Models\Event;
use App\Models\Thread;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component implements HasForms 
{
    use InteractsWithForms; 

    public Event $event;

    public $title;
    public $content;
    public $tags = [];

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
            SpatieTagsInput::make('tags')->required(),
        ];
    } 

    public function render()
    {
        return view('livewire.app.message-board.thread.create');
    }

    public function submit()
    {
        // validate
        $data = $this->form->getState();
        $thread = Thread::create([
            'event_id' => $this->event->id,
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'content' => $data['content'],
        ]);

        $thread->syncTags($this->tags);
    }
}
