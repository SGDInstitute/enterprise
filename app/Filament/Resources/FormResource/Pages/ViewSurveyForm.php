<?php

namespace App\Filament\Resources\FormResource\Pages;

use App\Filament\Resources\FormResource;
use App\Models\Form;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Arr;

class ViewSurveyForm extends Page
{
    protected static string $resource = FormResource::class;

    protected static string $view = 'filament.resources.form-resource.pages.survey';

    public Form $record;

    public function getTitle(): string
    {
        return $this->record->name . ' Results';
    }

    public function getResponsesByQuestionProperty()
    {
        $answers = $this->record->responses->unique('answers')->pluck('answers');

        return $this->record->form
            ->filter(fn ($question) => $question['type'] !== 'content')
            ->mapWithKeys(function ($entry) use ($answers) {
                $question = $entry['data'];
                $questionsAnswers = $answers->pluck($question['id']);

                if ($question['type'] === 'list' && (! isset($question['list-style']) || $question['list-style'] !== 'checkbox')) {
                    if (isset($question['list-other']) && $question['list-other']) {
                        $others = $answers->pluck($question['id'] . '-other')->filter(fn ($answer) => $answer !== null && $answer != '');

                        return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->countBy(), 'others' => $others->join(', ')]];
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->countBy()]];
                } elseif ($question['type'] === 'list' && $question['list-style'] === 'checkbox') {
                    if (isset($question['list-other']) && $question['list-other']) {
                        $others = $answers->pluck($question['id'] . '-other')->filter(fn ($answer) => $answer !== null && $answer != '');

                        return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->flatten()->countBy(), 'others' => $others->join(', ')]];
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->flatten()->countBy()]];
                } elseif ($question['type'] === 'matrix') {
                    $answers = [];

                    foreach ($question['options'] as $option) {
                        $answers[$option] = $questionsAnswers->map(fn ($answer) => Arr::get($answer, $option) ?? Arr::get($answer, ' ' . $option) ?? Arr::get($answer, $option . ' '))->countBy();
                    }

                    return [$question['id'] => ['question' => $question, 'answers' => $answers]];
                } else {
                    return [$question['id'] => ['question' => $question, 'answers' => $questionsAnswers->filter(fn ($answer) => $answer !== null && $answer != '' && $answer != 'n/a' && $answer != 'N/A' && $answer != '-')]];
                }
            });
    }

    public function getViewData(): array
    {
        return [
            'responses' => $this->responsesByQuestion,
        ];
    }
}
