<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Widgets\StatsOverview;
use App\Filament\Resources\EventResource\Widgets\TicketBreakdown;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function hasCombinedRelationManagerTabsWithForm(): bool
    {
        return true;
    }

    protected function getHeaderActions(): array
    {
        return [
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
                ->icon('heroicon-m-arrow-down-tray'),
            DeleteAction::make(),
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
            TicketBreakdown::class,
        ];
    }
}
