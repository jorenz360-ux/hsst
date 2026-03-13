<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Batch;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
      $startGradYear = 1899;
        $endGradYear   = (int) date('Y'); 

        $rows = [];

        for ($year = $startGradYear; $year <= $endGradYear; $year++) {
            $schoolYear = ($year - 1) . '-' . $year;

            $rows[] = [
                'yeargrad' => $year,
                'schoolyear' => $schoolYear,
            ];
        }

        Batch::upsert(
            $rows,
            uniqueBy: ['yeargrad'],    
            update: ['schoolyear']      
        );
    }
}
