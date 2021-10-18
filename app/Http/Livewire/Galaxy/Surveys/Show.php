<?php

namespace App\Http\Livewire\Galaxy\Surveys;

use App\Models\Form;
use Livewire\Component;

class Show extends Component
{
    public Form $survey;

    public function render()
    {
        return view('livewire.galaxy.surveys.show')
            ->layout('layouts.galaxy', ['title' => $this->survey->name . ' Responses'])
            ->with([
                'numberOfResponses' => $this->survey->responses->count(),
                'responsesByQuestion' => $this->responsesByQuestion,
            ]);
    }

    public function getResponsesByQuestionProperty()
    {
        $answers = $this->survey->responses->pluck('answers');

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
                        $answers[$option] = $questionsAnswers->map(fn($answer) => $answer[$option])->countBy();
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $answers]];
                } else {
                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->filter(fn($answer) => $answer !== null && $answer != '')]];
                }
            });
    }

}
