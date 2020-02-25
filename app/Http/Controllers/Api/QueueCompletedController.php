<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Queue;
use Illuminate\Http\Request;

class QueueCompletedController extends Controller
{
    public function __invoke($ids)
    {
        Queue::complete(explode(',', $ids));

        return Queue::where('completed', false)->get()->sortBy('created_at');
    }
}
