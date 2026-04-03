<?php

namespace Database\Seeders;

use App\Models\Committee;
use Illuminate\Database\Seeder;

class CommitteeSeeder extends Seeder
{
    public function run(): void
    {
        $committees = [
            'Ways & Means',
            'Ambiance & Decorations',
            'Athletic & Sports',
            'Banquet & Food',
            'Dental & Medical Mission',
            'Emergency & Paramedics',
            'Exhibit Set-up',
            'Liturgical & Worship',
            'Program & Entertainment',
            'Promotion & Publicity',
            'Registration & Guest Services',
            'Souvenir Program',
            'Mobilization',
            'Motorcade',
            'Awards & Recognitions',
            'Certificates, Plaques & Tokens',
            'Documentation',
            'Heritage Walk Through',
            'Hospitality, Reception & Welcome Committee',
            'School Familiarization Tour',
            'Specialized & Support',
            'Sponsorships',
            'Funds Management',
        ];

        foreach ($committees as $committee) {
            Committee::firstOrCreate(
                ['name' => $committee],
                ['is_active' => true]
            );
        }
    }
}