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
            $this->workshopForm = Form::create(['event_id' => $this->event->id, 'type' => 'workshop', 'name' => $this->event->name . ' Workshop Proposal']);
            $this->form = [];
        } else {
            $this->workshopForm = $this->event->workshopForm;
            $this->form = $this->workshopForm->form ?? [];
            $this->formattedStart = $this->workshopForm->formattedStart;
            $this->formattedEnd = $this->workshopForm->formattedEnd;
        }
    }

    public function render()
    {
        return view('livewire.galaxy.events.edit.workshop-form')
            ->with([
                'typeOptions' => $this->typeOptions,
                'timezones' => $this->timezones,
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

    public function addContent()
    {
        $this->form[] = ['style' => 'content', 'id' => 'content-', 'content' => ''];
    }

    public function addCollaborators()
    {
        $this->form[] = ['style' => 'collaborators', 'id' => 'collaborators'];
    }

    public function addQuestion()
    {
        $this->form[] = ['style' => 'question', 'id' => 'question-', 'question' => '', 'type' => '', 'rules' => ''];
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

    public function save()
    {
        // validate

        $this->workshopForm->start = Carbon::parse($this->formattedStart, $this->event->timezone)->timezone('UTC');
        $this->workshopForm->end = Carbon::parse($this->formattedEnd, $this->event->timezone)->timezone('UTC');
        $this->workshopForm->form = $this->form;

        $this->workshopForm->save();

        $this->emit('notify', ['message' => 'Successfully saved workshop form.', 'type' => 'success']);
    }
}
