<?php

use App\Enums\RoomStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('number_of_guests');
            $table->boolean('is_smoking_allowed');
            $table->integer('size');
            $table->string('measure_unit');
            $table->integer('price_for_night');
            $table->string('room_type');
            $table->string('status')->default(RoomStatus::NEW );
            $table->foreignId('hotel_id')->constrained(table: 'hotels', column: 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
