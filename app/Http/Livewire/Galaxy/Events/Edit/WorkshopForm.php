<?php

namespace App\Http\Livewire\Galaxy\Events\Edit;

use App\Http\Livewire\Traits\WithTimezones;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WorkshopForm extends Component
{
    use WithTimezones;

    public Event $event;
    public Form $workshopForm;

    public $form;
    public $formattedEnd;
    public $formattedStart;
    public $openIndex = -1;
    public $showSettings = false;

    public $rules = [
        'formattedStart' => 'required',
        'formattedEnd' => 'required',
        'workshopForm.timezone' => 'required',
        'workshopForm.auth_required' => '',
        'form' => 'required',
    ];

    public function mount()
    {
        if($this->event->workshopForm === null) {
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
            $this->formattedStart = $this->workshopForm->formattedStart;
            $this->formattedEnd = $this->workshopForm->formattedEnd;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.workshop-form')
            ->with([
                'fields' => $this->fields,
                'timezones' => $this->timezones,
                'typeOptions' => $this->typeOptions,
            ]);
    }

    public function getTypeOptionsProperty()
    {
        return [
            'text' => 'Text',
            'number' => 'Number',
            'textarea' => 'Textarea',
            'list' => 'List',
        ];
    }

    public function getFieldsProperty()
    {
        if(empty($this->form)) {
            return [];
        }

        return $this->form->filter(fn($item) => $item['style'] === 'question')->map(fn($question) => $question['id']);
    }

    public function addCondition()
    {
        $question = $this->form[$this->openIndex];
        $question['conditions'][] = ['field' => '', 'method' => '', 'value' => ''];
        $this->form[$this->openIndex] = $question;
    }

    public function addContent()
    {
        $this->form[] = ['style' => 'content', 'id' => 'content-', 'content' => ''];
        $this->openIndex = count($this->form)-1;
    }

    public function addCollaborators()
    {
        $this->form[] = ['style' => 'collaborators', 'id' => 'collaborators'];
        $this->openIndex = count($this->form)-1;
    }

    public function addQuestion()
    {
        $this->form[] = ['style' => 'question', 'id' => 'question-', 'question' => '', 'type' => '', 'rules' => ''];
        $this->openIndex = count($this->form)-1;
    }

    public function delete($index)
    {
        unset($this->form[$index]);
        $this->form = $this->form->values();
    }

    public function duplicate($index)
    {
        $this->form[] = $this->form[$index];
    }

    public function moveDown($index)
    {
        if($index !== 0) {
            $original = $this->form[$index];
            $below = $this->form[$index + 1];

            $this->form[$index] = $below;
            $this->form[$index + 1] = $original;
        }
    }

    public function moveUp($index)
    {
        if($index !== 0) {
            $original = $this->form[$index];
            $above = $this->form[$index - 1];

            $this->form[$index] = $above;
            $this->form[$index - 1] = $original;
        }
    }

    public function openSettings($index)
    {
        if($this->openIndex !== $index) {
            //whoops;
        }
        $this->showSettings = true;
    }

    public function save()
    {
        // validate

        $this->workshopForm->start = Carbon::parse($this->formattedStart, $this->event->timezone)->timezone('UTC');
        $this->workshopForm->end = Carbon::parse($this->formattedEnd, $this->event->timezone)->timezone('UTC');

        if($this->form !== []) {
            if(!is_array($this->form)) {
                $form = $this->form->toArray();
            } else {
                $form = $this->form;
            }

            foreach($form as $index => $item) {
                if($item['style'] === 'question' && $item['type'] === 'list' && is_string($item['options'])) {
                    $form[$index]['options'] = explode(",", preg_replace("/((\r?\n)|(\r\n?))/", ',', $item['options']));
                }
            }
            $this->workshopForm->form = $form;
        }

        $this->workshopForm->save();

        $this->emit('notify', ['message' => 'Successfully saved workshop form.', 'type' => 'success']);
    }

    public function setOpenIndex($index)
    {
        $this->openIndex = $index;
    }
}
