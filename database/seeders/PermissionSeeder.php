<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $permissions = [
            'users.view','users.create','users.edit','users.delete',
            'alumni.view','alumni.edit','alumni.edit.self',
            'generate.report',
            'event.view','create.event', 'edit.event','delete.event',
            'announcement.create','announcement.manage', 'view.upcoming.events',
             'view.alumni.dashboard', 'view.admin.dashboard', 'payments.view',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => $guard]);
        }

        // Roles (must exist)
        $coordinator = Role::firstOrCreate(['name' => 'reunion-coordinator', 'guard_name' => $guard]);
        $ssps        = Role::firstOrCreate(['name' => 'ssps', 'guard_name' => $guard]);
        $batchRep    = Role::firstOrCreate(['name' => 'batch-representative', 'guard_name' => $guard]);
        $alumni      = Role::firstOrCreate(['name' => 'alumni', 'guard_name' => $guard]);

        // reunion-coordinator gets all
        // $coordinator->syncPermissions($permissions);
         $coordinator->syncPermissions([
                'users.view','users.create','users.edit',
                'alumni.view',
                'generate.report',
                'event.view','create.event', 'edit.event','delete.event',
                'announcement.create','announcement.manage',
                'view.admin.dashboard', "payments.view"
         ]);

        // ssps (staff)
        $ssps->syncPermissions([
            'users.view','users.create','users.edit',
            'alumni.view',
            'payments.view','payments.verify','payments.export',
            'donations.view','donations.verify',
            'batches.view', 'generate.report',
            'announcement.create',
        ]);

        // batch representative
        $batchRep->syncPermissions([
            'batches.view',
            'alumni.view',
            'donation.manage',
            'generate.report',
            'payments.view',
        ]);

        // alumni
        $alumni->syncPermissions([
            'alumni.edit.self',
            'donations.create',
            'payments.create',
            'payments.view',
            'view.upcoming.events',
            'view.alumni.dashboard',
        ]);
    }
}
