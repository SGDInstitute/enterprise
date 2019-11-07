<?php

namespace App\Listeners;

use App\Events\ActivititesUploaded;
use App\Imports\ActivititesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportActivities
{

    public function __construct()
    {
        //
    }

    public function handle(ActivititesUploaded $event)
    {
        Excel::import(new ActivititesImport, $event->path);
    }
}
