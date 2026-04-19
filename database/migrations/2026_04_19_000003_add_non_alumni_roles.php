<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

// Non-alumni roles are seeded here (not in PermissionSeeder) so `php artisan migrate`
// creates them automatically in production. Note: `ssps-member` is for non-alumni SSPS
// personnel and is distinct from the `ssps` admin role.
return new class extends Migration
{
    public function up(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        $permission = Permission::firstOrCreate([
            'name' => 'view.staff.dashboard',
            'guard_name' => $guard,
        ]);

        foreach (['staff', 'employee', 'ssps-member'] as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guard,
            ]);
            $role->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (['staff', 'employee', 'ssps-member'] as $roleName) {
            Role::where('name', $roleName)->where('guard_name', 'web')->first()?->delete();
        }

        Permission::where('name', 'view.staff.dashboard')->where('guard_name', 'web')->first()?->delete();
    }
};
