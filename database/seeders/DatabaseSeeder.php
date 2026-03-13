<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // $admin = User::firstOrCreate([
        //     'email' => 'ssps@example.com',
        // ], [
        //     'username' => 'ssps111',
        //     'password' => bcrypt('ssps'), // always hash passwords
        //     'alumni_id' => null,
        // ]);

        // // Assign role using Spatie
        // $admin->assignRole('ssps');

         $this->call([
        BatchSeeder::class,
    ]);
    }
}
