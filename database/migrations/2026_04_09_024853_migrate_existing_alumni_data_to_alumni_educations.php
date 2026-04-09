<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $alumniRows = DB::table('alumni')
            ->whereNotNull('batch_id')
            ->get();

        foreach ($alumniRows as $row) {
            $exists = DB::table('alumni_educations')
                ->where('alumni_id', $row->id)
                ->where('batch_id', $row->batch_id)
                ->exists();

            if (! $exists) {
                DB::table('alumni_educations')->insert([
                    'alumni_id' => $row->id,
                    'batch_id' => $row->batch_id,
                    'did_graduate' => $row->did_graduate ?? true,
                    'school_year_attended' => $row->school_year_attended,
                    'is_batch_rep' => $row->is_batch_rep ?? false,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('alumni_educations')->delete();
    }
};