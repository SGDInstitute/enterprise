<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Arr;

class ReviewResponse extends Page implements HasForms
{   
    use InteractsWithForms;

    public Response $record;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'filament.resources.response-resource.pages.review';

    protected function getActions(): array
    {
        return [
            //
        ];
    }

    protected function getViewData(): array
    {
        return [
            'qa' => $this->questionsAndAnswers,
        ];
    }

    public function getQuestionsAndAnswersProperty()
    {
        return $this->record->form->questions
            ->mapWithKeys(function ($item) {
                $id = Arr::get($item, isset($item['data']) ? 'data.id' : 'id');
                $question = Arr::get($item, isset($item['data']) ? 'data.question' : 'question');

                return [$question => $this->record->answers[$id]
                    ? $this->record->answers[$id]
                    : 'was not answered', ];
            });
    }

    protected function getFormSchema(): array
    {
        return [
            Radio::make('alignment')
                ->label('Alignment with conference theme & target audience')
                ->options([
                    3 => '3: Submission strongly aligns with the intended outcomes of the conference',
                    2 => '2: Submission generally aligns with the intended outcomes of the conference',
                    1 => '1: Submission loosely aligns with the intended outcomes of the conference',
                    0 => '0: Submission did not include information about how it aligns with the theme and target audience',
                ])
                ->required(),
            Radio::make('priority')
                ->label('Priority of Topic Covered')
                ->options([
                    3 => '3: Submission covers a high priority topic',
                    2 => '2: Submissions covers medium priority topic',
                    1 => '1: Submission covers a low priority topic',
                    0 => '0: Submission did not include enough information to score in this category',
                ])
                ->required(),
            Radio::make('presenter_experience')
                ->label('Appropriateness of presenter covering this content')
                ->options([
                    3 => '3: Submission covers a high priority topic',
                    2 => '2: Submissions covers medium priority topic',
                    1 => '1: Submission covers a low priority topic',
                    0 => '0: Submission did not include enough information to score in this category',
                ])
                ->required(),
            Radio::make('track')
                ->label('Including workshop in a track (only applicable to submissions where track options have been selected)')
                ->options([
                    3 => '3: Submission strongly aligns with a selected track description and should be considered for a track slot',
                    2 => '2: Submission generally aligns with a selected track and could be considered for a track slot as space allows',
                    1 => '1: Submission loosely aligns with a selected track and would be better suited for a general session',
                    0 => '0: Submission did not include enough information to score in this category or not tracks were selected',
                ])
                ->required(),
            Textarea::make('notes')->required(),
        ];
    }
}
