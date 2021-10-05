<?php

namespace App\Observers;

use App\Models\EventItem;

class EventItemObserver
{
    public function updating(EventItem $item)
    {
        if($item->isDirty('start') || $item->isDirty('end')) {
            if($item->children->isNotEmpty()) {
                $item->children->each(function($child) use ($item) {
                    $child->start = $item->start;
                    $child->end = $item->end;
                    $child->save();
                });
            }
        }
    }
}
