<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use App\Models\RfpReview;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Arr;

class ReviewResponse extends Page implements HasForms
{   
    use InteractsWithForms;

    public Response $record;

    public $alignment;
    public $experience;
    public $notes;
    public $priority;
    public $track;

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

    public function submit()
    {
        RfpReview::create([
            'user_id' => auth()->id(),
            'form_id' => $this->record->form_id,
            'response_id' => $this->record->id,
            ...$this->form->getState(),
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Radio::make('alignment')
                ->label('Alignment with conference theme & target audience')
                ->options([
                    3 => 'Strongly aligns',
                    2 => 'Generally aligns',
                    1 => 'Loosely aligns',
                    0 => 'Does not say',
                ])
                ->descriptions([
                    3 => '3 points',
                    2 => '2 points',
                    1 => '1 points',
                    0 => '0 points',
                ])
                ->required(),
            Radio::make('priority')
                ->label('Priority of Topic Covered')
                ->options([
                    3 => 'High priority',
                    2 => 'Medium priority',
                    1 => 'Low priority',
                    0 => 'Does not say',
                ])
                ->descriptions([
                    3 => '3 points',
                    2 => '2 points',
                    1 => '1 points',
                    0 => '0 points',
                ])
                ->required(),
            Radio::make('experience')
                ->label('Appropriateness of presenter covering this content')
                ->options([
                    3 => 'Highly qualified',
                    2 => 'Adequately qualified',
                    1 => 'May not be qualified',
                    0 => 'Is not qualified',
                ])
                ->descriptions([
                    3 => '3 points',
                    2 => '2 points',
                    1 => '1 points',
                    0 => '0 points',
                ])
                ->required(),
            Radio::make('track')
                ->label('Including workshop in a track (only applicable to submissions where track options have been selected)')
                ->options([
                    3 => 'Strongly aligns',
                    2 => 'Generally aligns',
                    1 => 'Loosely aligns',
                    0 => 'Does not say'
                ])
                ->descriptions([
                    3 => '3 points',
                    2 => '2 points',
                    1 => '1 points',
                    0 => '0 points',
                ])
                ->required(),
            Textarea::make('notes')->required(),
        ];
    }
}
