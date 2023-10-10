<?php

namespace App\Listeners;

use App\Events\WorkshopStatusChanged;
use App\Models\Order;
use App\Notifications\WorkshopCanceled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class CancelWorkshop implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(WorkshopStatusChanged $event): void
    {
        if ($event->workshop->status !== 'canceled') {
            return;
        }

        // remove comped orders
        Order::where('transaction_id', "comped-workshop-{$event->workshop->id}")->delete();
        Notification::send($event->workshop->collaborators, new WorkshopCanceled($event->workshop));

        // remove invites
        $event->workshop->invitations->each->delete();

        // @todo notify anyone who signed up for the workshop
    }
}
