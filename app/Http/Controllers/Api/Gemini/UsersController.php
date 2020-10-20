<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Models\Event;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\UserResource;
use App\Models\Schedule;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user());
    }

    public function update()
    {
        $userData = request()->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $profile = request()->validate([
            'pronouns' => '',
            'sexuality' => '',
            'gender' => '',
            'race' => '',
            'college' => '',
            'tshirt' => '',
        ]);

        $user = auth()->user();

        $oldEmail = $user->email;

        $user->update($userData);

        if (request('email') !== $oldEmail) {
            $user->sendConfirmationEmail();
        }

        $userProfile = $user->profile;

        $userProfile->update($profile);

        return new UserResource($user);
    }
}
