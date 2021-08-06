<?php

namespace App\Http\Livewire\Galaxy\Events\Show;

use App\Http\Livewire\Traits\WithFiltering;
use App\Http\Livewire\Traits\WithSorting;
use App\Models\Event;
use App\Models\Form;
use App\Models\Response;
use Livewire\Component;
use Livewire\WithPagination;

class Workshops extends Component
{
    use WithPagination, WithSorting, WithFiltering;

    public Event $event;
    public Form $form;

    public $advanced = [];
    public $advancedChanged = false;
    public $filters =  [
        'search' => ''
    ];
    public $perPage = 25;

    public function mount()
    {
        $this->form = $this->event->workshopForm;

        if($this->form->settings->get('searchable')) {
            $this->setAdvancedForm();
        }
    }

    public function updating($field)
    {
        if(strpos($field, 'advanced') !== false) {
            $this->advancedChanged = true;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.show.workshops')
            ->with([
                'workshops' => $this->workshops,
                'advancedSearchForm' => $this->advancedSearchForm,
            ]);
    }

    public function getAdvancedSearchFormProperty()
    {
        return $this->form->form->whereIn('id', $this->form->settings->searchable);
    }

    public function getWorkshopsProperty()
    {
        return Response::query()
            ->with(['form', 'collaborators'])
            ->where('type', 'workshop')
            ->when($this->filters['search'] !== '', function($query) {
                $search = trim($this->filters['search']);

                if($this->form->settings->get('searchable', []) !== []) {
                    foreach($this->form->settings->get('searchable') as $index => $item) {
                        $function = $index === 0 ? 'where' : 'orWhere';

                        $query->$function('answers->' . $item, 'LIKE', '%' . $search . '%');
                    }
                } else {
                    $query->where('answers->name', 'LIKE', '%' . $search . '%');
                }

                $query->orWhere('status', 'LIKE', '%' . $search . '%');
            })
            ->when($this->advancedChanged, function($query) {
                foreach($this->advanced as $id => $value) {
                    if(is_array($value) && $value !== []) {
                        $query->whereIn('answers->' . $id, $value);
                    } elseif(is_string($value)) {
                        $query->where('answers->' . $id, 'LIKE', '%' . trim($value) . '%');
                    }
                }
            })
            ->where('form_id', $this->form->id)
            ->paginate($this->perPage);
    }

    public function setAdvancedForm()
    {
        $this->advanced = $this->form->form
            ->whereIn('id', $this->form->settings->searchable)
            ->mapWithKeys(function($item) {
                if($item['style'] === 'question') {
                    if($item['type'] === 'list') {
                        return [$item['id'] => []];
                    }
                    return [$item['id'] => ''];
                }
            })->toArray();
    }
}
