<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ReportsDownloadController extends Controller
{
    public function show($name)
    {
        $class = "App\Admin\Reports\\" . ucfirst($name);

        $report = new $class;

        return Excel::create($report->filename . '-' . now(), function ($excel) use ($report) {
            $excel->sheet($report->name, function ($sheet) use ($report) {
                $sheet->loadView($report->view)->with('data', $report->query());
            });
        })->download('xlsx');
    }
}
