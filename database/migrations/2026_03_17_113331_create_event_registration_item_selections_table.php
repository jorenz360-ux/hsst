<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registration_item_selections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('registration_id');
            $table->unsignedBigInteger('event_registration_item_id');

            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->timestamps();

            $table->foreign('registration_id', 'eris_reg_fk')
                ->references('id')
                ->on('event_registrations')
                ->cascadeOnDelete();

            $table->foreign('event_registration_item_id', 'eris_item_fk')
                ->references('id')
                ->on('event_registration_items')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registration_item_selections');
    }
};