<?php

use Illuminate\Database\Seeder;

class OtherResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Survey::create([
            'name'      => 'Other Response Test',
            'slug'      => str_slug('other-test'),
            'list_id'   => '8ghda09IULHIUdjwefd98we4',
            'start'     => '2017-09-08 00:00:00',
            'end'       => '2017-11-25 00:00:00',
            'is_public' => true,
            'form'      => json_decode(file_get_contents(base_path("database/seeds/data/otherTestForm.json"))),
        ]);
    }
}
