<?php

namespace App\Http\Livewire\Galaxy;

use App\Models\Response;
use Livewire\Component;

class Responses extends Component
{
    public $formId = null;

    public $type = null;

    public $userId = null;

    public function render()
    {
        return view('livewire.galaxy.responses')
            ->layout('layouts.galaxy', ['title' => 'Reservations'])
            ->with([
                'responses' => $this->responses,
            ]);
    }

    public function getResponsesProperty()
    {
        return Response::query()
            ->with(['form', 'collaborators'])
            ->when($this->formId !== null, function ($query) {
                $query->where('form_id', $this->formId);
            })
            ->when($this->type !== null, function ($query) {
                $query->where('type', $this->type);
            })
            ->when($this->userId !== null, function ($query) {
                $query->where('user_id', $this->userId);
            })
            ->when($this->filters['search'] !== '', function ($query) {
                $search = trim($this->filters['search']);

                if ($this->form->settings->get('searchable', []) !== []) {
                    foreach ($this->form->settings->get('searchable') as $index => $item) {
                        $function = $index === 0 ? 'where' : 'orWhere';

                        $query->$function('answers->'.$item, 'LIKE', '%'.$search.'%');
                    }
                } else {
                    $query->where('answers->name', 'LIKE', '%'.$search.'%');
                }

                $query->orWhere('status', 'LIKE', '%'.$search.'%');
            })
            ->when($this->advancedChanged, function ($query) {
                foreach ($this->advanced as $id => $value) {
                    if (is_array($value) && $value !== []) {
                        $query->whereIn('answers->'.$id, $value);
                    } elseif (is_string($value)) {
                        $query->where('answers->'.$id, 'LIKE', '%'.trim($value).'%');
                    }
                }
            })
            ->where('form_id', $this->form->id)
            ->paginate($this->perPage);
    }
}
