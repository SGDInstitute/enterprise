<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Kenepa\MultiWidget\MultiWidget;

class EventMultiWidget extends MultiWidget
{
    public array $widgets = [
        StatsOverview::class,
        TicketFormOverview::class,
    ];
}
