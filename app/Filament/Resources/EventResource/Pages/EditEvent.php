<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Exports\ScheduledPresentersExport;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Widgets\EventMultiWidget;
use App\Filament\Resources\EventResource\Widgets\StatsOverview;
use App\Filament\Resources\EventResource\Widgets\TicketBreakdown;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Maatwebsite\Excel\Facades\Excel;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
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
                            "{$this->record->slug}-event-dashboard.pdf"
                        );
                    }),
                Action::make('Scheduled Presenters')
                    ->action(fn () =>
                        Excel::download(new ScheduledPresentersExport($this->record), "{$this->record->slug}-scheduled-presenters.xlsx")
                    ),
            ])
            ->button()
            ->label('Exports')
            ->icon('heroicon-m-arrow-down-tray')
            ->outlined(),
            DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            EventMultiWidget::class,
            TicketBreakdown::class,
        ];
    }
}
