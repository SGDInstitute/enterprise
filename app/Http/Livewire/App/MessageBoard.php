<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Tags\Tag;

class MessageBoard extends Component
{
    use WithPagination;

    public Event $event;

    public $perPage = 12;
    public $search = '';
    public $tagsFilter = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'tagsFilter' => ['except' => [], 'as' => 't'],
    ];

    public function updating($field)
    {
        if (in_array($field, ['filters', 'search'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.app.message-board', [
            'records' => $this->getTableQuery()->paginate($this->perPage),
            'tags' => Tag::withType('posts')->get(),
        ]);
    }

    protected function getTableQuery(): Builder
    {
        return Post::forEvent($this->event)
            ->approved()
            ->when($this->tagsFilter !== [], function ($query) {
                $query->withAllTags($this->tagsFilter, 'posts');
            })
            ->when($this->search, function ($query) {
                $query->where(fn ($query) => $query
                    ->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                );
            });
    }
}
