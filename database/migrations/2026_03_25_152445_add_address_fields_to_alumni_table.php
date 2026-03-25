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
        Schema::table('alumni', function (Blueprint $table) {
            $table->string('address_line_1')->nullable()->after('batch_id');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city', 120)->nullable()->after('address_line_2');
            $table->string('state_province', 120)->nullable()->after('city');
            $table->string('postal_code', 30)->nullable()->after('state_province');
            $table->string('country', 100)->nullable()->after('postal_code');

            // Optional Google-related fields
            $table->text('formatted_address')->nullable()->after('country');
            $table->string('place_id')->nullable()->after('formatted_address');
            $table->decimal('latitude', 10, 7)->nullable()->after('place_id');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn([
                'address_line_1',
                'address_line_2',
                'city',
                'state_province',
                'postal_code',
                'country',
                'formatted_address',
                'place_id',
                'latitude',
                'longitude',
            ]);
        });
    }
};