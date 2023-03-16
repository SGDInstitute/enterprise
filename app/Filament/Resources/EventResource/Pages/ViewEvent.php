<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Widgets\StatsOverview;
use App\Filament\Resources\EventResource\Widgets\TicketBreakdown;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEvent extends ViewRecord
{
    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.events.pages.view-event';

    protected function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getActions(): array
    {
        return [
            EditAction::make(),
            Action::make('Dashboard Report')
                ->action(function () {
                    $breakdown = new TicketBreakdown;
                    $breakdown->record = $this->record;
                    $stats = new StatsOverview;
                    $stats->record = $this->record;
                    $pdf = Pdf::loadView('pdf.event-dashboard', [
                        'daysLeft' => $stats->daysLeft,
                        'reservations' => $stats->reservationTotals,
                        'orders' => $stats->orderTotals,
                        'potentialMoney' => $stats->potentialMoney,
                        'moneyMade' => $stats->moneyMade,
                        'tablePaid' => $breakdown->tablePaidData(),
                        'tableFilled' => $breakdown->tableFilledData(),
                    ]);

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        'filename.pdf'
                    );
                })
                ->icon('heroicon-s-download'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            TicketBreakdown::class,
        ];
    }
}
