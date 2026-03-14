<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class alumniSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $alumniRole = Role::firstOrCreate([
            'name' => 'alumni',
            'guard_name' => $guard,
        ]);

        $alumni = User::updateOrCreate(
            ['username' => 'alumni123'],
            [
                'email' => 'alumni@hsst.com',
                'password' => Hash::make('alumni123!'),
                'must_change_password' => true,
                'alumni_id' => null,
            ]
        );

        if (! $alumni->hasRole($alumniRole->name)) {
            $alumni->assignRole($alumniRole);
        }
    }
}