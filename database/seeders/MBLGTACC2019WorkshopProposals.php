<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MBLGTACC2019WorkshopProposals extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Form::create([
            'name' => 'MBLGTACC 2019 Workshop Proposals',
            'slug' => Str::slug('MBLGTACC 2019 Workshop Proposals'),
            'event_id' => 2,
            'start' => '2018-10-01 00:00:00',
            'end' => '2018-11-25 00:00:00',
            'is_public' => true,
            'button_text' => 'Submit Proposal',
            'form' => json_decode(file_get_contents(base_path('database/seeds/data/mblgtacc2019WorkshopsForm.json'))),
        ]);
    }
}
