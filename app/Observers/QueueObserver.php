<?php

namespace App\Observers;

use App\Models\EventBadgeQueue;

class QueueObserver
{
    public function created(EventBadgeQueue $badge)
    {
        //
    }

    public function updated(EventBadgeQueue $badge)
    {
        if($badge->printed) {
            $badge->markAsPrinted();
        }
    }

    public function deleted(EventBadgeQueue $badge)
    {
        //
    }

    public function restored(EventBadgeQueue $badge)
    {
        //
    }

    public function forceDeleted(EventBadgeQueue $badge)
    {
        //
    }
}
