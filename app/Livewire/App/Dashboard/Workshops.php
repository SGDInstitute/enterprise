<?php

namespace App\Livewire\App\Dashboard;

use App\Livewire\Traits\WithFiltering;
use App\Livewire\Traits\WithSorting;
use App\Models\Response;
use Filament\Notifications\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class Workshops extends Component
{
    use WithFiltering;
    use WithPagination;
    use WithSorting;

    public $form;

    public $filters = [
        'search' => '',
    ];

    public $perPage = 25;

    protected $listeners = ['refresh' => '$refresh'];

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
            ->leftJoin('collaborators', 'collaborators.response_id', '=', 'responses.id')
            ->with('collaborators', 'form')
            ->where(function ($query) {
                $query->where('responses.user_id', auth()->id())
                    ->orWhere('collaborators.user_id', auth()->id());
            })
            ->select('responses.*')
            ->groupBy('responses.id')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function delete($id)
    {
        $this->workshops->find($id)->safeDelete();

        $this->dispatch('refresh');

        Notification::make()
            ->success()
            ->title('Successfully deleted workshop submission')
            ->send();
    }

    public function finalizeFormNeeded($workshop)
    {
        return in_array($workshop->status, ['confirmed', 'scheduled', 'approved'])
            && ! $workshop->form->finalizeForm->responses()->where('parent_id', $workshop->id)->exists();
    }

    public function finalizeFormSubmitted($workshop)
    {
        return in_array($workshop->status, ['confirmed', 'scheduled', 'approved'])
            && $workshop->form->finalizeForm->responses()->where('parent_id', $workshop->id)->exists();
    }
}
