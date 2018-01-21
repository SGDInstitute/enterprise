<?php

namespace App\Admin\Reports;

use Illuminate\Support\Facades\DB;

class Accommodation extends Report
{
    public $name = 'Accommodations';

    public $filename = 'Accommodations-Report';

    public $view = 'admin.reports.accommodation';

    public function query()
    {
        return DB::table('users')
            ->join('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.id', 'users.name', 'users.email', 'profiles.pronouns', 'profiles.sexuality', 'profiles.gender', 'profiles.race', 'profiles.college', 'profiles.tshirt', 'profiles.wants_program', 'profiles.accommodation')
            ->whereNotNull('profiles.accommodation')
            ->get();
    }
}
