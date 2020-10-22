<?php

namespace Database\Seeders;

use Database\Seeders\ActivityTypeSeeder;
use Database\Seeders\DeveloperSeeder;
use Database\Seeders\EventsSeeder;
use Database\Seeders\OrdersSeeder;
use Database\Seeders\OtherResponseSeeder;
use Database\Seeders\ResponsesSeeder;
use Database\Seeders\RolesPermissionsSeeder;
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
        $this->call(OrdersSeeder::class);
        $this->call(ResponsesSeeder::class);
        // $this->call(OtherResponseSeeder::class);
        $this->call(ActivityTypeSeeder::class);
    }
}
