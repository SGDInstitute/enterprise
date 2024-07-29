<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Tags\Tag;

class RolePermissionSeeder extends Seeder
{
    public $roles = [
        'institute' => [
            'galaxy.view',
            'view_dashboard',
        ],
        'mblgtacc' => [
            'galaxy.view',
            'view_dashboard',
        ],
        'mblgtacc_planner' => [
            'galaxy.view',
            'view_dashboard',
        ], // @todo can remove?
        'developer' => [
            'create_attendee',
            'create_event',
            'create_support',
            'delete_attendees',
            'delete_event',
            'delete_order',
            'delete_rates',
            'delete_support',
            'delete_user',
            'edit_attendees',
            'edit_event',
            'edit_order',
            'edit_rates',
            'edit_support',
            'edit_user',
            'galaxy.view',
            'impersonate',
            'manage_roles',
            'view_dashboard',
            'view_logs',
        ],
    ];

    public function run(): void
    {
        foreach ($this->roles as $name => $permissions) {
            foreach ($permissions as $permissionName) {
                if (! Permission::whereName($permissionName)->exists()) {
                    Permission::create(['name' => $permissionName]);
                }
            }

            $role = Role::create(['name' => $name]);
            $role->syncPermissions($permissions);
        }
    }
}
