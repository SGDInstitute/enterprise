<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Exports\ScheduledPresentersExport;
use App\Exports\ScheduleExport;
use App\Exports\TicketAnswersExport;
use App\Exports\TicketUsersExport;
use App\Exports\VolunteersExport;
use App\Filament\Resources\EventResource;
use App\Filament\Resources\EventResource\Widgets\EventMultiWidget;
use App\Filament\Resources\EventResource\Widgets\StatsOverview;
use App\Filament\Resources\EventResource\Widgets\TicketBreakdown;
use App\Notifications\EventCheckIn;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification;
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
            Action::make('close-checkin')
                ->action(function () {
                    $this->record->settings->allow_checkin = false;
                    $this->record->save();
                })
                ->button()
                ->color('gray')
                ->outlined()
                ->hidden($this->record->start->diffInDays(now()) > 14 || $this->record->settings->allow_checkin !== true),
            Action::make('open-checkin')
                ->action(function () {
                    $this->record->settings->allow_checkin = true;
                    $this->record->save();

                    Notification::send($this->record->paidInPersonAttendees(), new EventCheckIn($this->record));
                })
                ->requiresConfirmation()
                ->modalHeading('Open Checkin')
                ->modalDescription('Are you sure you\'d like to open & allow attendees to check-in. This will send a notification to all paid attendees.')
                ->button()
                ->color('gray')
                ->outlined()
                ->hidden(fn () => now()->diffInDays($this->record->start) > 14 || $this->record->settings->allow_checkin === true),
            Action::make('reports')
                ->url(EventResource::getUrl('report', ['record' => $this->record]))
                ->button()
                ->outlined(),
            ActionGroup::make([
                Action::make('dashboard-report')
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
                            fn () => print ($pdf->output()),
                            "{$this->record->slug}-event-dashboard.pdf"
                        );
                    }),
                Action::make('scheduled-presenters')
                    ->action(fn () => Excel::download(new ScheduledPresentersExport($this->record), "{$this->record->slug}-scheduled-presenters.xlsx")
                    ),
                Action::make('volunteers')
                    ->action(fn () => Excel::download(new VolunteersExport($this->record), "{$this->record->slug}-volunteers.xlsx")
                    ),
                Action::make('ticket-answers')
                    ->label('Who Needs What (Ticket Answers)')
                    ->form(function () {
                        $keys = $this->record->ticketTypes->pluck('form')->map->pluck('id')->flatten()->unique();

                        return [
                            Select::make('question')
                                ->options($keys->combine($keys)),
                            Radio::make('status')
                                ->options([
                                    'paid' => 'Paid',
                                    'unpaid' => 'Unpaid',
                                ]),
                        ];
                    })
                    ->action(fn ($data) => Excel::download(
                        new TicketAnswersExport($this->record, $data['question'], $data['status']),
                        "{$this->record->slug}-ticket-answers.xlsx"
                    )),
                Action::make('ticket-users')
                    ->label('Attendees')
                    ->form([
                        Radio::make('status')
                            ->options([
                                'paid' => 'Paid',
                                'unpaid' => 'Unpaid',
                            ]),
                    ])
                    ->action(fn ($data) => Excel::download(new TicketUsersExport($this->record, $data['status']), "{$this->record->slug}-ticket-users.xlsx")
                    ),
                Action::make('export-schedule-txt')
                    ->label('Schedule Export (txt)')
                    ->action(function () {
                        $parents = $this->record->items()->whereNull('parent_id')->orderBy('start')->with('children')->get();
                        $contents = view('exports.copyable-schedule', ['items' => $parents])->render();

                        $date = now()->format('Y-m-d');

                        return response()->streamDownload(
                            fn () => print ($contents),
                            "schedule-export-{$date}.txt"
                        );
                    }),
                Action::make('export-schedule-xlsx')
                    ->label('Schedule Export (xlsx)')
                    ->action(function () {
                        $date = now()->format('Y-m-d');

                        return Excel::download(new ScheduleExport($this->record->id), "schedule-export-{$date}.xlsx");
                    }),
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
