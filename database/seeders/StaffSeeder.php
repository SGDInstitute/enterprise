<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(['name' => 'Justin Drwencke', 'email' => 'justin@sgdinstitute.org'])->assignRole('institute');
        User::factory()->create(['name' => 'Andy Newhouse', 'email' => 'andy@sgdinstitute.org'])->assignRole('institute');
    }
}
