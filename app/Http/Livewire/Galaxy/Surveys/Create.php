<?php

namespace App\Http\Livewire\Galaxy\Surveys;

use App\Http\Livewire\Traits\WithFormBuilder;
use App\Http\Livewire\Traits\WithTimezones;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Create extends Component
{
    use WithTimezones;
    use WithFormBuilder;

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
        'survey.auth_required' => 'boolean',
        'searchable' => '',
        'form' => '',
    ];

    public function mount()
    {
        if (isset($this->survey)) {
            $this->form = $this->survey->form ?? collect([]);
            $this->formattedStart = $this->survey->formattedStart;
            $this->formattedEnd = $this->survey->formattedEnd;
        } else {
            $this->survey = new Form(['type' => 'survey', 'event_id' => '']);
            $this->form = collect([]);
        }
    }

    public function render()
    {
        return view('livewire.galaxy.surveys.form')
            ->layout('layouts.galaxy', ['title' => 'Create Survey'])
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
            ->filter(fn($question) => $question['style'] === 'question')
            ->filter(fn($question) => $question['type'] !== 'textarea')
            ->pluck('question', 'id');
    }

    public function save()
    {
        // validate

        $this->survey->start = Carbon::parse($this->formattedStart, $this->event->timezone ?? $this->survey->timezone)->timezone('UTC');
        $this->survey->end = Carbon::parse($this->formattedEnd, $this->event->timezone ?? $this->survey->timezone)->timezone('UTC');

        if ($this->form !== []) {
            if (! is_array($this->form)) {
                $form = $this->form->toArray();
            } else {
                $form = $this->form;
            }

            foreach ($form as $index => $item) {
                if ($item['style'] === 'question' && $item['type'] === 'list' && is_string($item['options'])) {
                    $form[$index]['options'] = explode(',', preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['options']));
                }
            }
            $this->survey->form = $form;
        }

        if ($this->searchable !== []) {
            $this->survey->settings->set('searchable', $this->searchable);
        }

        if ($this->survey->event_id == '') {
            $this->survey->event_id = null;
        }
        $this->survey->type = 'survey';
        $this->survey->save();

        $this->emit('notify', ['message' => 'Successfully saved survey.', 'type' => 'success']);
        return redirect()->route('galaxy.surveys.edit', $this->survey);
    }
}
