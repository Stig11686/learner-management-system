<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $learnerRole = Role::create(['name' => 'learner']);
        $managerRole = Role::create(['name' => 'manager']);
        $coachRole = Role::create(['name' => 'coach']);

        // Create permissions
        Permission::create(['name' => 'view learner dashboard']);
        Permission::create(['name' => 'manage learners']);
        Permission::create(['name' => 'view-cohorts']);
        Permission::create(['name' => 'view-learners']);

        // Assign permissions to roles
        $learnerRole->givePermissionTo('view learner dashboard');
        $managerRole->givePermissionTo('manage learners');
        $managerRole->givePermissionTo('view-cohorts');
        $managerRole->givePermissionTo('view-learners');
        $coachRole->givePermissionTo('view-learners');
    }

}
