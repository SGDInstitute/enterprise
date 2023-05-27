<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Arr;

class ReviewResponse extends Page
{   
    public Response $record;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'filament.resources.response-resource.pages.review';

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
}
