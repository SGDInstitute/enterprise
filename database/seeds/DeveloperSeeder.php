<?php

use App\User;
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
            'name' => 'Andrea Swick',
            'email' => 'andrea@sgdinstitute.org',
            'password' => bcrypt('Password1'),
            'confirmed_at' => Carbon\Carbon::now(),
        ]);

        $user->givePermissionTo('view dashboard');
    }
}
