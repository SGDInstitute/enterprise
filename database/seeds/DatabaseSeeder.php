<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EventsSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        $this->call(DeveloperSeeder::class);
        $this->call(MBLGTACC2017ConferenceEvaluation::class);
        $this->call(MBLGTACC2018WorkshopProposals::class);
        $this->call(MBLGTACC2018VolunteerForm::class);
        $this->call(mblgtacc2018CareerResourceFair::class);

    }
}
