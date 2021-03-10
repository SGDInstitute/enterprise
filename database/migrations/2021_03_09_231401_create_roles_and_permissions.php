<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesAndPermissions extends Migration
{
    public function up()
    {
        $institute = Role::create(['name' => 'institute']);
        $mblgtacc = Role::create(['name' => 'mblgtacc']);

        $galaxyView = Permission::create(['name' => 'galaxy.view']);

        $institute->givePermissionTo($galaxyView);
        $mblgtacc->givePermissionTo($galaxyView);
    }
}
