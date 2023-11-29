<?php

namespace App\Livewire\Galaxy\Forms;

use App\Livewire\Traits\WithFormBuilder;
use App\Livewire\Traits\WithTimezones;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Edit extends Component
{
    use WithFormBuilder;
    use WithTimezones;

    public Event $event;

    public Form $survey;

    public $form;

    public $formattedEnd;

    public $formattedStart;

    public $openIndex = -1;

    public $showSettings = false;

    public $searchable = [];

    public $rules = [
        'formattedStart' => 'required',
        'formattedEnd' => 'required',
        'survey.name' => 'required',
        'survey.event_id' => 'nullable',
        'survey.timezone' => 'required',
        'survey.auth_required' => '',
        'searchable' => '',
        'form' => 'required',
    ];

    public function mount()
    {
        $this->form = $this->survey->form ?? collect([]);
        $this->formattedStart = $this->survey->formattedStart;
        $this->formattedEnd = $this->survey->formattedEnd;
    }

    public function render()
    {
        return view('livewire.galaxy.surveys.form')
            ->layout('layouts.galaxy', ['title' => 'Edit Survey'])
            ->with([
                'events' => $this->events,
                'fields' => $this->fields,
                'timezones' => $this->timezones,
                'typeOptions' => $this->typeOptions,
                'searchableFields' => $this->searchableFields,
            ]);
    }

    public function getEventsProperty()
    {
        return Event::select('id', 'name')->get();
    }

    public function getSearchableFieldsProperty()
    {
        return collect($this->form)
            ->filter(fn ($question) => $question['style'] === 'question')
            ->filter(fn ($question) => $question['type'] !== 'textarea')
            ->pluck('question', 'id');
    }

    public function save()
    {
        // validate

        $this->survey->start = Carbon::parse($this->formattedStart, $this->survey->timezone)->timezone('UTC');
        $this->survey->end = Carbon::parse($this->formattedEnd, $this->survey->timezone)->timezone('UTC');

        if ($this->form !== []) {
            if (! is_array($this->form)) {
                $form = $this->form->toArray();
            } else {
                $form = $this->form;
            }

            foreach ($form as $index => $item) {
                if ($item['style'] === 'question' && ($item['type'] === 'list' || $item['type'] === 'matrix') && is_string($item['options'])) {
                    $form[$index]['options'] = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['options']));
                }
                if ($item['style'] === 'question' && $item['type'] === 'matrix' && is_string($item['scale'])) {
                    $form[$index]['scale'] = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['scale']));
                }
            }
            $this->survey->form = $form;
        }

        if ($this->searchable !== []) {
            $this->survey->settings->set('searchable', $this->searchable);
        }
        $this->survey->save();

        $this->dispatch('notify', ['message' => 'Successfully saved workshop form.', 'type' => 'success']);
    }
}
