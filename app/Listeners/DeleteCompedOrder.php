<?php

namespace App\Listeners;

use App\Events\ShiftsFellBelowLimit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteCompedOrder implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ShiftsFellBelowLimit $event): void
    {
        $event->user->orders()
            ->where('event_id', $event->event->id)
            ->where('transaction_id', 'comped-volunteer')
            ->delete();
    }
}
