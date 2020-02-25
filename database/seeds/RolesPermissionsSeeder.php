<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    protected $roles = [
        'institute', 'mblgtacc_planner', 'developer',
    ];

    protected $permission = [
        'impersonate',
        'view_logs',
        'edit_user',
        'delete_user',
        'edit_order',
        'delete_order',
        'edit_attendees',
        'delete_attendees',
        'edit_event',
        'delete_event',
        'edit_rates',
        'delete_rates',
        'create_support',
        'edit_support',
        'delete_support',
        'view_dashboard',
        'create_event',
        'create_attendee',
        'manage_roles',
        'create_permission',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $index => $role) {
            Role::create(['name' => $role]);
        }

        $developer = Role::findByName('developer');
        $institute = Role::findByName('institute');
        $mblgtaccPlanner = Role::findByName('mblgtacc_planner');

        foreach ($this->permission as $index => $permission) {
            $p = Permission::create(['name' => $permission]);

            $developer->givePermissionTo($p);

            if ($permission === 'view_dashboard') {
                $institute->givePermissionTo($p);
                $mblgtaccPlanner->givePermissionTo($p);
            }
        }
    }
}
