<?php

namespace App\Http\Livewire\App;

use App\Models\Event;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class MessageBoard extends Component
{
    use WithPagination;

    public Event $event;

    public $categoriesFilter = [];
    public $perPage = 12;
    public $search = '';
    public $typesFilter = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'typesFilter' => ['except' => [], 'as' => 't'],
        'categoriesFilter' => ['except' => [], 'as' => 'c'],
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
            'categories' => [],
            'types' => [],
        ]);
    }

    protected function getTableQuery(): Builder
    {
        return Thread::forEvent($this->event);
    }
}
