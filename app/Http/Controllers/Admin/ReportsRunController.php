<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReportsRunController extends Controller
{
    public function store($name)
    {
        $class = "App\Admin\Reports\\" . ucfirst($name);

        $report = new $class;

        return response()->json(['data' => [
            'name' => $name,
            'html' => $report->generateHtml(),
            'download' => "/admin/reports/{$name}/download"
        ]]);
    }
}
