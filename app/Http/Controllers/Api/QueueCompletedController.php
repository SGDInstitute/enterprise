<?php

namespace App\Http\Controllers\Api;

use App\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QueueCompletedController extends Controller
{
    public function __invoke($ids)
    {
        Queue::complete(explode(',', $ids));
    }
}
