<?php

namespace App\Admin\Reports;

use Illuminate\Support\Facades\DB;

class ProgramGuide extends Report
{
    public $name = 'Program Guide';

    public $filename = 'Program-Guide-Report';

    public $view = 'admin.reports.program_guide';

    public function query()
    {
        return array_count_values(DB::table('profiles')->select('wants_program')->get()->pluck('wants_program')->all());
    }
}
