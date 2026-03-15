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

        $permissionGroups = [
            'users' => [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
            ],

            'alumni' => [
                'alumni.view',
                'alumni.edit',
                'alumni.edit.self',
            ],

            'reports' => [
                'generate.report',
            ],

            'events' => [
                'event.view',
                'create.event',
                'edit.event',
                'delete.event',
                'view.upcoming.events',
            ],

            'announcements' => [
                'announcement.create',
                'announcement.manage',
            ],

            'payments' => [
                'payments.view',
                'payments.create',
                'payments.verify',
                'payments.export',
            ],

            'donations' => [
                'donations.view',
                'donations.create',
                'donations.verify',
                'donation.manage',
            ],

            'batches' => [
                'batches.view',
            ],

            'dashboards' => [
                'view.alumni.dashboard',
                'view.admin.dashboard',
                'view.batchRep.dashboard',
                'view.ssps.dashboard',
            ],
        ];

        $permissions = collect($permissionGroups)
            ->flatten()
            ->unique()
            ->values()
            ->toArray();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }

        $coordinator = Role::firstOrCreate([
            'name' => 'reunion-coordinator',
            'guard_name' => $guard,
        ]);

        $ssps = Role::firstOrCreate([
            'name' => 'ssps',
            'guard_name' => $guard,
        ]);

        $batchRep = Role::firstOrCreate([
            'name' => 'batch-representative',
            'guard_name' => $guard,
        ]);

        $alumni = Role::firstOrCreate([
            'name' => 'alumni',
            'guard_name' => $guard,
        ]);

        $coordinator->syncPermissions([
            'users.view',
            'users.create',
            'users.edit',
            'alumni.view',
            'generate.report',
            'event.view',
            'create.event',
            'edit.event',
            'delete.event',
            'announcement.create',
            'announcement.manage',
            'view.admin.dashboard',
            'payments.view',
        ]);

        $ssps->syncPermissions([
            'users.view',
            'users.create',
            'users.edit',
            'alumni.view',
            'payments.view',
            'payments.verify',
            'payments.export',
            'donations.view',
            'donations.verify',
            'batches.view',
            'generate.report',
            'announcement.create',
            'view.ssps.dashboard',
        ]);

        $batchRep->syncPermissions([
            'batches.view',
            'alumni.view',
            'donation.manage',
            'generate.report',
            'payments.view',
            'view.batchRep.dashboard',
        ]);

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