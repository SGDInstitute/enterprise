<?php

namespace App\Features;

use App\Models\Event;
use App\Models\User;

class EventMessageBoard
{
    public function resolve(mixed $scope): mixed
    {
        if (get_class($scope) === User::class) {
            $event = Event::where('slug', request()->route('event'))->firstOrFail();

            return $event->settings->get('enable_message_board', false);
        } else {
            return $scope->settings->get('enable_message_board', false);
        }
    }
}
