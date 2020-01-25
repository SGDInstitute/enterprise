<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class EventsDiscountController extends Controller
{
    public function __invoke(Event $event)
    {
        $shiftCount = $event->schedules()->with('activities.users')->where('title', 'Volunteer Track')->get()->flatMap->activities->filter(function ($activity) {
            return $activity->users->firstWhere('id', auth()->id());
        })->count();

        $discount = $event->ticket_types()->where('type', 'discount')->get()->filter(function ($discount) use ($shiftCount) {
            return Str::startsWith($discount->name, $shiftCount);
        })->first();

        auth()->user()->discounts()->sync($discount->id);
    }
}
