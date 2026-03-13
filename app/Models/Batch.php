<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'schoolyear',
        'yeargrad',
    ];

     public static function ensureUpToCurrentYear(int $startYear = 1899): void
    {
        $currentYear = (int) now()->format('Y');

        // Find the max year we currently have in DB
        $maxYear = (int) (self::max('yeargrad') ?? 0);

        // If table is empty or has garbage low values, start from $startYear
        $from = max($startYear, $maxYear + 1);

        // Nothing to do
        if ($from > $currentYear) {
            return;
        }

        $now = now();
        $rows = [];

        for ($year = $from; $year <= $currentYear; $year++) {
            $rows[] = [
                'yeargrad' => $year,
                'schoolyear' => ($year - 1) . '-' . $year,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        self::insert($rows);
    }

    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }
}

