<?php

namespace App\Http\Controllers\Api\Gemini;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UsersPushController extends Controller
{
    public function store()
    {
        auth()->user()->push_token = request('token');
        auth()->user()->save();

        return new UserResource(auth()->user());
    }
}
