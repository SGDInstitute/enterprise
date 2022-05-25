<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Http\Livewire\Traits\WithFormBuilder;
use App\Http\Livewire\Traits\WithTimezones;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WorkshopForm extends Component
{
    use WithTimezones;
    use WithFormBuilder;

    public Event $event;
    public Form $workshopForm;

    public $form;
    public $formattedEnd;
    public $formattedStart;
    public $openIndex = -1;
    public $reminders;
    public $showSettings = false;
    public $searchable = [];
    public $table = [['Criteria']];

    public $rules = [
        'formattedStart' => 'required',
        'formattedEnd' => 'required',
        'workshopForm.timezone' => 'required',
        'workshopForm.auth_required' => '',
        'searchable' => '',
        'form' => 'required',
    ];

    public function mount()
    {
        if ($this->event->workshopForm === null) {
            $this->workshopForm = Form::create([
                'event_id' => $this->event->id,
                'type' => 'workshop',
                'name' => $this->event->name . ' Workshop Proposal',
                'timezone' => $this->event->timezone,
            ]);
            $this->form = [];
        } else {
            $this->workshopForm = $this->event->workshopForm;
            $this->form = $this->workshopForm->form ?? collect([]);
            $this->table = $this->workshopForm->settings->rubric ?? [['Criteria']];
            $this->formattedStart = $this->workshopForm->formattedStart;
            $this->formattedEnd = $this->workshopForm->formattedEnd;
            $this->reminders = $this->workshopForm->settings->reminders;
            $this->searchable = $this->workshopForm->settings->searchable;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.workshop-form')
            ->with([
                'fields' => $this->fields,
                'timezones' => $this->timezones,
                'typeOptions' => $this->typeOptions,
                'searchableFields' => $this->searchableFields,
            ]);
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
        $this->workshopForm->start = Carbon::parse($this->formattedStart, $this->event->timezone)->timezone('UTC');
        $this->workshopForm->end = Carbon::parse($this->formattedEnd, $this->event->timezone)->timezone('UTC');

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
            $this->workshopForm->form = $form;
        }
        if ($this->table !== []) {
            $this->workshopForm->settings->rubric = $this->table;
        }

        if ($this->searchable !== []) {
            $this->workshopForm->settings->set('searchable', $this->searchable);
        }
        if ($this->reminders !== '') {
            $this->workshopForm->settings->set('reminders', $this->reminders);
        }
        $this->workshopForm->save();

        $this->emit('notify', ['message' => 'Successfully saved workshop form.', 'type' => 'success']);
    }
}
