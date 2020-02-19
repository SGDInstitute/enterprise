<?php

namespace App\Listeners;

use App\Events\ActivitiesUploaded;
use App\Imports\ActivitiesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportActivities
{
    public function __construct()
    {
        //
    }

    public function handle(ActivitiesUploaded $event)
    {
        Excel::import(new ActivitiesImport, $event->path);
    }
}
