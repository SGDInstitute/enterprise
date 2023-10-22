<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Models\Event;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ReportEvent extends Page
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event-resource.pages.report-event';

    public Event $record;

    public function getTitle(): string | Htmlable
    {
        return $this->record->name . ' Reports';
    }
}
