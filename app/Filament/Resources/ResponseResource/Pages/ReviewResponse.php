<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use App\Models\RfpReview;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Arr;

class ReviewResponse extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'filament.resources.response-resource.pages.review';

    public Response $record;

    public $editingReview;

    public $alignment;
    public $experience;
    public $notes;
    public $priority;
    public $track;

    public function mount(): void
    {
        if ($review = $this->reviews->firstWhere('user_id', auth()->id())) {
            $this->editingReview = $review;
            $this->form->fill([
                'alignment' => $review->alignment,
                'experience' => $review->experience,
                'priority' => $review->priority,
                'track' => $review->track,
                'notes' => $review->notes,
            ]);
        }
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

    public function getReviewsProperty()
    {
        return $this->record->reviews->load('user');
    }

    public function submit()
    {
        if ($this->editingReview) {
            $this->editingReview->update($this->form->getState());
            $title = 'Updated successfully';
        } else {
            $this->editingReview = RfpReview::create([
                'user_id' => auth()->id(),
                'form_id' => $this->record->form_id,
                'response_id' => $this->record->id,
                ...$this->form->getState(),
            ]);
            $title = 'Created successfully';
        }

        Notification::make() 
            ->title($title)
            ->success()
            ->send(); 
    }

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
            'reviews' => $this->reviews,
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Radio::make('alignment')
                ->label('Alignment with conference theme & target audience')
                ->disabled($this->cannotReviewProposal(auth()->id()))
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
                ->disabled($this->cannotReviewProposal(auth()->id()))
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
                ->disabled($this->cannotReviewProposal(auth()->id()))
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
                ->disabled($this->cannotReviewProposal(auth()->id()))
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
            Textarea::make('notes')
                ->disabled($this->cannotReviewProposal(auth()->id()))
                ->required(),
        ];
    }

    private function cannotReviewProposal($userId)
    {
        return $this->record->status === 'work-in-progress' ||
            ($userId === $this->record->user_id || $this->record->collaborators->pluck('id')->contains($userId));
    }
}
