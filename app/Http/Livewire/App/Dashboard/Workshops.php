<?php

namespace App\Http\Livewire\App\Dashboard;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Workshops extends Component
{
    use WithPagination;
    use WithSorting;
    use WithFiltering;

    public $filters = [
        'search' => '',
    ];

    public $perPage = 25;

    public function render()
    {
        return view('livewire.app.dashboard.workshops')
            ->with([
                'workshops' => $this->workshops,
            ]);
    }

    public function getWorkshopsProperty()
    {
        return Response::query()
            ->with(['form', 'collaborators'])
            ->where('type', 'workshop')
            ->where('user_id', auth()->id())
            ->paginate($this->perPage);
    }
}
