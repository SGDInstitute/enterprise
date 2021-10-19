<?php

namespace App\Http\Livewire\Galaxy\Surveys;

use App\Models\Form;
use Illuminate\Support\Arr;
use Livewire\Component;

class Show extends Component
{
    public Form $survey;

    public $foundAnswer = null;
    public $foundResponses = null;
    public $showModal = false;

    public function render()
    {
        return view('livewire.galaxy.surveys.show')
            ->layout('layouts.galaxy', ['title' => $this->survey->name . ' Responses'])
            ->with([
                'numberOfResponses' => $this->survey->responses->count(),
                'numberOfUniqueResponses' => $this->survey->responses->unique('answers')->count(),
                'responsesByQuestion' => $this->responsesByQuestion,
            ]);
    }

    public function getResponsesByQuestionProperty()
    {
        $answers = $this->survey->responses->unique('answers')->pluck('answers');

        return $this->survey->form
            ->mapWithKeys(function($question) use ($answers) {
                $questionsAnswers = $answers->pluck($question['id']);

                if($question['type'] === 'list' && (!isset($question['list-style']) || $question['list-style'] !== 'checkbox')) {
                    if(isset($question['list-other']) && $question['list-other']) {
                        $others = $answers->pluck($question['id'] . '-other')->filter(fn($answer) => $answer !== null && $answer != '');

                        return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->countBy(), 'others' => $others->join(', ')]];
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->countBy()]];
                } elseif($question['type'] === 'list' && $question['list-style'] === 'checkbox') {
                    if(isset($question['list-other']) && $question['list-other']) {
                        $others = $answers->pluck($question['id'] . '-other')->filter(fn($answer) => $answer !== null && $answer != '');

                        return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->flatten()->countBy(), 'others' => $others->join(', ')]];
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->flatten()->countBy()]];
                } elseif($question['type'] === 'matrix') {
                    $answers = [];

                    foreach($question['options'] as $option) {
                        $answers[$option] = $questionsAnswers->map(fn($answer) => Arr::get($answer, $option) ?? Arr::get($answer, " ".$option) ?? Arr::get($answer, $option." "))->countBy();
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $answers]];
                } else {
                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->filter(fn($answer) => $answer !== null && $answer != '' && $answer != 'n/a' && $answer != 'N/A' && $answer != "-")]];
                }
            });
    }

    public function closeModal()
    {
        $this->reset('showModal', 'foundAnswer', 'foundResponses');
    }

    public function delete($id)
    {
        $this->survey->responses->find($id)->delete();

        $this->emit('notify', ['message' => 'Deleted response', 'type' => 'success']);

        if($this->showModal) {
            $this->foundResponses = $this->survey->responses()->where('answers', 'like', '%' . $this->foundAnswer . '%')->get();
        }
    }

    public function showFullResponse($answer)
    {
        $this->foundAnswer = $answer;
        $this->foundResponses = $this->survey->responses()->where('answers', 'like', '%' . $answer . '%')->get();

        $this->showModal = true;
    }
}
