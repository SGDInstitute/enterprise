<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Andy Swick',
            'email' => 'andy@sgdinstitute.org',
            'password' => bcrypt('Password1'),
            'confirmed_at' => Carbon\Carbon::now(),
        ]);

        $user->assignRole('institute', 'developer');
    }
}
