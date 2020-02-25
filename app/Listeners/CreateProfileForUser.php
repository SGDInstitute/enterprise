<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateProfileForUser
{
    public function __construct()
    {
        //
    }

    public function handle(UserCreated $event)
    {
        $event->user->profile()->save(new Profile());
    }
}
