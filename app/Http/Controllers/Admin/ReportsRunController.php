<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ReportsRunController extends Controller
{
    public function store($name)
    {
        $class = "App\Admin\Reports\\" . Str::studly($name);

        $report = new $class;

        return response()->json(['data' => [
            'name' => $name,
            'html' => $report->generateHtml(),
            'download' => "/admin/reports/{$name}/download"
        ]]);
    }
}
