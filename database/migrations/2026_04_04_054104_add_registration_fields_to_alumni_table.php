<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('prefix', 20)->nullable()->after('id');
            $table->string('suffix', 20)->nullable()->after('lname');
            $table->string('cellphone', 30)->nullable()->after('occupation');
            $table->string('educational_level', 30)->nullable()->after('cellphone');
            $table->boolean('did_graduate')->default(true)->after('educational_level');
        });
    }

    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn([
                'prefix',
                'suffix',
                'cellphone',
                'educational_level',
                'did_graduate',
            ]);
        });
    }
};