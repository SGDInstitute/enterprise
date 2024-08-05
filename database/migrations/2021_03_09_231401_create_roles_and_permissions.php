<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $institute = Role::create(['name' => 'institute']);
        $mblgtacc = Role::create(['name' => 'mblgtacc']);

        $galaxyView = Permission::create(['name' => 'galaxy.view']);

        $institute->givePermissionTo($galaxyView);
        $mblgtacc->givePermissionTo($galaxyView);
    }
};
