<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('address_line_1')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('state_province')->nullable()->change();
            $table->string('postal_code')->nullable()->change();
            $table->unsignedInteger('years_working')->nullable()->change();
            $table->string('position')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->string('address_line_1')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->string('state_province')->nullable(false)->change();
            $table->string('postal_code')->nullable(false)->change();
            $table->unsignedInteger('years_working')->nullable(false)->change();
            $table->string('position')->nullable(false)->change();
        });
    }
};
