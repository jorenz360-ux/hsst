<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->enum('level', ['elementary', 'highschool', 'college'])
                ->nullable()
                ->after('id');
        });

        DB::table('batches')
            ->whereNull('level')
            ->update(['level' => 'college']);

        Schema::table('batches', function (Blueprint $table) {
            $table->dropUnique('batches_yeargrad_unique');
            $table->unique(['level', 'yeargrad'], 'batches_level_yeargrad_unique');
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropUnique('batches_level_yeargrad_unique');
            $table->unique('yeargrad', 'batches_yeargrad_unique');
            $table->dropColumn('level');
        });
    }
};