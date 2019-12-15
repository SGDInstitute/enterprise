<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Profile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
