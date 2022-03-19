<?php

namespace App\Http\Livewire\Galaxy\Responses;

use App\Models\Response;
use Livewire\Component;

class Show extends Component
{
    public Response $response;

    public function render()
    {
        return view('livewire.galaxy.responses.show')
            ->layout('layouts.galaxy', ['title' => $this->response->name])
            ->with([
                'qa' => $this->questionsAndAnswers,
            ]);
    }

    public function getQuestionsAndAnswersProperty()
    {
        return $this->response->form->form->filter(fn ($item) => $item['style'] === 'question')
            ->mapWithKeys(function ($item) {
                return [$item['question'] => $this->response->answers[$item['id']] ? $this->response->answers[$item['id']] : 'was not answered'];
            });
    }
}
