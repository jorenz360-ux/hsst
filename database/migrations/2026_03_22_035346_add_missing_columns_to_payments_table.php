<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'reference_number')) {
                $table->string('reference_number')->nullable()->after('mode');
            }

            if (!Schema::hasColumn('payments', 'or_number')) {
                $table->string('or_number')->nullable()->after('reference_number');
            }

            if (!Schema::hasColumn('payments', 'or_file_path')) {
                $table->string('or_file_path')->nullable()->after('or_number');
            }

            if (!Schema::hasColumn('payments', 'remarks')) {
                $table->string('remarks')->nullable()->after('or_file_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'reference_number',
                'or_number',
                'or_file_path',
                'remarks'
            ]);
        });
    }
};
