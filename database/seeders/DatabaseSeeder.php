<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@reunion2026.com'],
            [
                'username' => 'admin',
                'password' => Hash::make('admin@hsst'),
                'alumni_id' => 18,
            ]
        );

        // Assign reunion-coordinator role
        $admin->assignRole('reunion-coordinator');

         $this->call([
        BatchSeeder::class,
    ]);
    }
}
