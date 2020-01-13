<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Event;
use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user());
    }
}
