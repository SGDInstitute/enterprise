<?php

use Illuminate\Database\Seeder;
use App\Admin\Report;

class ReportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $report = factory(Report::class)->create([
            'name' => 'Accessability',
            'view' => 'admin.reports.accessability',
            'query' => [
                'table' => 'user',
                'join' => "'profiles', 'users.id', '=', 'profiles.user_id'",
                'select' => "'users.id', 'users.name', 'users.email', 'profiles.pronouns', 'profiles.sexuality', 'profiles.gender', 'profiles.race', 'profiles.college', 'profiles.tshirt', 'profiles.wants_program', 'profiles.accommodation'",
                'whereNotNull' => 'profiles.accommodations',
                'get' => ''
            ]
        ]);

        // factory(Report::class)->create(['name' => 'Registration']);
        // factory(Report::class)->create(['name' => 'Program Check']);
        // factory(Report::class)->create(['name' => 'T-Shirts']);
    }
}
