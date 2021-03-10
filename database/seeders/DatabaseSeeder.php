<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create(['name' => 'Andy Newhouse', 'email' => 'andy@sgdinstitute.org'])->assignRole('institute');

        Event::factory()->preset('mblgtacc')->create(['name' => 'MBLGTACC 2021', 'timezone' => 'America/Chicago']);
        Event::factory()->preset('tjt')->create();
    }
}
