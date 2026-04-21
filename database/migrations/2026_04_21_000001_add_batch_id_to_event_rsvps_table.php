<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_rsvps', function (Blueprint $table) {
            $table->foreignId('batch_id')
                ->nullable()
                ->after('alumni_id')
                ->constrained('batches')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('event_rsvps', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
    }
};
