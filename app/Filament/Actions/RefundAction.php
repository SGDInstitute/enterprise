<?php

namespace App\Filament\Actions;

use App\Notifications\Refund;
use Filament\Forms\Components\Checkbox;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class RefundAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'refund';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->form(fn (Model $record) => [...$this->ticketCheckboxes($record)])
            ->action(function (Model $record, array $data): void {
                $ticketsToRefund = array_keys(array_filter($data, fn ($value) => $value));
                $refundAmount = $this->calculateRefundAmount($record, $ticketsToRefund);

                if ($record->isStripe()) {
                    $refund = $record->user->refund($record->transaction_id, ['amount' => $refundAmount]);
                    activity()->performedOn($record)->withProperties(['amount' => $refundAmount, 'refund_id' => $refund->id])->log('partial_refund');
                } else {
                    activity()->performedOn($record)->withProperties(['amount' => $refundAmount, 'refund_id' => 'check'])->log('partial_refund');
                }

                $record->update([
                    'amount' => $record->amount - $refundAmount,
                ]);

                $record->tickets->whereIn('id', $ticketsToRefund)->each->delete();

                if ($record->tickets->count() === count($ticketsToRefund)) {
                    $record->delete();
                }

                $record->user->notify(new Refund($record, $refundAmount, count($ticketsToRefund)));

                Notification::make()->title('Refund processed.')->success()->send();
            });
    }

    private function calculateRefundAmount($record, $ticketsToRefund)
    {
        return $record->tickets->whereIn('id', $ticketsToRefund)->sum(fn ($ticket) => $ticket->price->cost);
    }

    private function ticketCheckboxes($record)
    {
        return $record->tickets->load(['user', 'ticketType', 'price'])->map(
            fn ($ticket) => Checkbox::make($ticket->id)
                ->label(($ticket->user->name ?? 'Ticket ' . $ticket->id) . " ({$ticket->ticketType->name} - {$ticket->price->formattedCost})")
        );
    }
}
