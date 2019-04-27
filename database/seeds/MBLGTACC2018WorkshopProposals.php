<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MBLGTACC2018WorkshopProposals extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Form::create([
            'name' => 'MBLGTACC 2018 Workshop Proposals',
            'slug' => Str::slug('MBLGTACC 2018 Workshop Proposals'),
            'event_id' => 2,
            'start' => '2017-09-08 00:00:00',
            'end' => '2017-11-25 00:00:00',
            'is_public' => true,
            'button_text' => 'Submit Proposal',
            'form' => json_decode(file_get_contents(base_path("database/seeds/data/mblgtacc2018WorkshopsForm.json"))),
        ]);
    }
}
