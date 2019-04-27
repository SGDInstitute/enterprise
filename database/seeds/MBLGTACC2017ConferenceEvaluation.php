<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MBLGTACC2017ConferenceEvaluation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Form::create([
            'name'      => 'MBLGTACC 2017 Conference Evaluation',
            'slug'      => Str::slug('MBLGTACC 2017 Conference Evaluation'),
            'list_id'   => 'BSx8zuuc0FGzkJ763l7iI67g',
            'start'     => '2017-02-19 00:00:00',
            'end'       => '2017-03-31 00:00:00',
            'is_public' => true,
            'form'      => json_decode(file_get_contents(base_path("database/seeds/data/mblgtacc2017form.json"))),
        ]);
    }
}
