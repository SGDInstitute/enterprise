<?php

namespace App\Livewire\Galaxy\Responses;

use App\Models\Form;
use App\Models\Response;
use Livewire\Component;

class Show extends Component
{
    public Response $formResponse;

    public Form $form;

    public $tags;

    public function mount($response)
    {
        $this->formResponse = Response::with('form')->find($response);
        $this->tags = $this->formResponse->settings->get('tags', []);
        $this->form = $this->formResponse->form;
    }

    public function updatedTags()
    {
        $this->formResponse->settings['tags'] = $this->tags;
        $this->formResponse->save();
        $this->dispatch('notify', ['message' => 'Saved tags', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.galaxy.responses.show')
            ->layout('layouts.galaxy', ['title' => $this->formResponse->name])
            ->with([
                'qa' => $this->questionsAndAnswers,
            ]);
    }

    public function getQuestionsAndAnswersProperty()
    {
        return $this->form->form->filter(fn ($item) => $item['style'] === 'question')
            ->mapWithKeys(function ($item) {
                return [$item['id'] => $this->formResponse->answers[$item['id']]
                    ? $this->formResponse->answers[$item['id']]
                    : 'was not answered', ];
            });
    }
}
