<?php

namespace App\Observers;

use App\Models\EventBadgeQueue;

class QueueObserver
{
    public function created(EventBadgeQueue $badge): void
    {
        //
    }

    public function updated(EventBadgeQueue $badge): void
    {
        if ($badge->printed) {
            $badge->markAsPrinted();
        }
    }

    public function deleted(EventBadgeQueue $badge): void
    {
        //
    }

    public function restored(EventBadgeQueue $badge): void
    {
        //
    }

    public function forceDeleted(EventBadgeQueue $badge): void
    {
        //
    }
}
