<?php

namespace App\Livewire\App;

use App\Models\Event;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class MessageBoard extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Event $event;

    public function render()
    {
        return view('livewire.app.message-board');
    }

    public function createAction(): Action
    {
        return Action::make('create')
            ->form([
                TextInput::make('title')->required(),
                RichEditor::make('content')
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                    ])
                    ->required(),
                Select::make('tags')
                    ->options([
                        'Travel',
                        'Lodging',
                        'North Dakota',
                        'South Dakota',
                        'Nebraska',
                        'Kansas',
                        'Minnesota',
                        'Iowa',
                        'Missouri',
                        'Wisconsin',
                        'Illinois',
                        'Michigan',
                        'Michigan (UP)',
                        'Indiana',
                        'Kentucky',
                        'Ohio',
                    ])
                    ->multiple()
                    ->required(),
            ])
            ->action(fn () => $this->post->delete());
    }
}
