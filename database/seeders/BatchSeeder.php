<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $startYear = 1900;
        $endYear = now()->year;
        $levels = ['elementary', 'highschool', 'college'];

        foreach (range($startYear, $endYear) as $yeargrad) {
            $schoolyear = ($yeargrad - 1) . '-' . $yeargrad;

            foreach ($levels as $level) {
                Batch::updateOrCreate(
                    [
                        'level' => $level,
                        'yeargrad' => $yeargrad,
                    ],
                    [
                        'schoolyear' => $schoolyear,
                    ]
                );
            }
        }
    }
}