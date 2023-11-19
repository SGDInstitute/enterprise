<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            StaffSeeder::class,
            EventsSeeder::class,
            MessageBoardTagsSeeder::class,
        ]);
    }
}
