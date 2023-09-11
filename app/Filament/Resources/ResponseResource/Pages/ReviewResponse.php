<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use App\Models\RfpReview;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Arr;

class ReviewResponse extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

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

    public function getReviewsProperty()
    {
        return $this->record->reviews->load('user');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Split::make([
                    Section::make([
                        ...$this->record->form->questions->map(function ($item) {
                            $entry = TextEntry::make("answers.{$item['data']['id']}")
                                ->label($item['data']['question'])
                                ->placeholder('was not answered');

                            if ($item['data']) {
                                $entry->html();
                            }

                            return $entry;
                        }),
                    ])->grow(),
                    Section::make([
                        Actions::make([
                            Action::make('view-rubric')
                                ->icon('heroicon-m-table-cells')
                                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                                ->modalContent(view('filament.resources.response-resource.actions.rubric'))
                                ->modalSubmitAction(false)
                                ->modalWidth('6xl')
                                ->outlined(),
                            Action::make('view-tracks')
                                ->icon('heroicon-m-rectangle-group')
                                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                                ->modalContent(view('filament.resources.response-resource.actions.tracks'))
                                ->modalSubmitAction(false)
                                ->modalWidth('6xl')
                                ->outlined(),
                            Action::make('view-scores-and-notes')
                                ->icon('heroicon-m-sparkles')
                                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                                ->modalContent(fn () => view('filament.resources.response-resource.actions.scores-n-notes', ['reviews' => $this->reviews]))
                                ->modalSubmitAction(false)
                                ->modalWidth('6xl')
                                ->outlined(),
                            Action::make('resetStars')
                                ->icon('heroicon-m-x-mark')
                                ->color('danger')
                                ->requiresConfirmation(),
                        ]),
                        TextEntry::make('form.name'),
                        TextEntry::make('type'),
                        TextEntry::make('user.name'),
                        TextEntry::make('collaborators.name')
                            ->listWithLineBreaks()
                            ->bulleted(),
                        TextEntry::make('invitations.name')
                            ->listWithLineBreaks()
                            ->bulleted(),
                        TextEntry::make('status'),
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
                ])->from('md')
            ]);
    }

    public function submit()
    {
        $data = $this->form->getState();
        $data['score'] = $data['alignment'] + $data['priority'] + $data['experience'] + $data['track'];

        if ($this->editingReview) {
            $this->editingReview->update($data);
            $title = 'Updated successfully';
        } else {
            $this->editingReview = RfpReview::create([
                'user_id' => auth()->id(),
                'form_id' => $this->record->form_id,
                'response_id' => $this->record->id,
                ...$data,
            ]);
            $title = 'Created successfully';
        }

        Notification::make()
            ->title($title)
            ->success()
            ->send();
    }

    public function reviewForm(): array
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
