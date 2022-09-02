<?php

namespace App\Http\Livewire\Galaxy\Forms;

use App\Http\Livewire\Traits\WithTimezones;
use App\Models\Event;
use App\Models\Form as Model;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Form extends Component
{
    use WithTimezones;

    public Event $event;
    public Model $form;

    public $formattedStart;
    public $formattedEnd;
    public $tab = 'info';
    public $searchable = [];

    protected $rules = [
        'form.type' => 'required',
        'form.parent_id' => '',
        'form.name' => 'required',
        'form.event_id' => '',
        'formattedStart' => '',
        'formattedEnd' => '',
        'form.timezone' => '',
        'form.auth_required' => ['required', 'boolean'],
        'form.is_internal' => ['required', 'boolean'],
        'searchable' => '',
    ];

    public function mount($form = null)
    {
        if ($form === null) {
            $this->form = new Model();
            $this->builder = collect([]);
        } else {
            $this->form = $form;
            $this->formattedEnd = $this->form->end->timezone($this->form->timezone)->format('Y-m-d');
            $this->formattedStart = $this->form->start->timezone($this->form->timezone)->format('Y-m-d');
            $this->builder = $this->form->form ?? collect([]);
        }
    }

    public function updatedFormEventId($id)
    {
        $this->form['timezone'] = $this->events->find($id)->timezone;
    }

    public function render()
    {
        return view('livewire.galaxy.forms.form')
            ->layout('layouts.galaxy', ['title' => 'Configure Form'])
            ->with([
                'events' => $this->events,
                'forms' => $this->forms,
                'searchableFields' => $this->searchableFields,
                'timezones' => $this->timezones,
                'types' => $this->types,
            ]);
    }

    public function getEventsProperty()
    {
        return Event::select('id', 'name', 'timezone')->orderBy('created_at', 'desc')->get();
    }

    public function getFormsProperty()
    {
        return Model::select('id', 'name')->orderBy('created_at', 'desc')->get();
    }

    public function getSearchableFieldsProperty()
    {
        return collect($this->form->form)
            ->filter(fn ($question) => $question['style'] === 'question')
            ->filter(fn ($question) => $question['type'] !== 'textarea')
            ->pluck('question', 'id');
    }

    public function getTypesProperty()
    {
        return [
            'form' => 'Form',
            'survey' => 'Survey',
            'workshop' => 'Workshop',
            'review' => 'Sub Form: Review (internal)',
            'confirmation' => 'Sub Form: Confirmation',
            'finalize' => 'Sub Form: Finalize',
        ];
    }

    public function saveInfo()
    {
        $this->validate();

        $this->form->end = Carbon::parse($this->formattedEnd, $this->form->timezone)->endOfDay()->timezone('UTC');
        $this->form->start = Carbon::parse($this->formattedStart, $this->form->timezone)->startOfDay()->timezone('UTC');
        $this->form->form = $this->builder;

        if ($this->searchable !== []) {
            $this->form->settings->set('searchable', $this->searchable);
        }

        $this->form->save();
        $this->emit('notify', ['type' => 'success', 'message' => 'Successfully saved form']);
        $this->tab = 'builder';
    }
}
