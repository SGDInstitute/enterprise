<?php

namespace App\Http\Controllers\Api\Gemini;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UsersPushController extends Controller
{
    public function store()
    {
        auth()->user()->push_token = request('token');
        auth()->user()->save();

        return new UserResource(auth()->user());
    }
}
