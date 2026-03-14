<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $adminRole = Role::firstOrCreate([
            'name' => 'reunion-coordinator',
            'guard_name' => $guard,
        ]);

        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@hsst.com',
                'password' => Hash::make('Admin123!'),
                'must_change_password' => true,
                'alumni_id' => null,
            ]
        );

        if (! $admin->hasRole($adminRole->name)) {
            $admin->assignRole($adminRole);
        }
    }
}