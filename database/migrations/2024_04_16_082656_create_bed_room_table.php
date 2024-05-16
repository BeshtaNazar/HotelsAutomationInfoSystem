<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bed_room', function (Blueprint $table) {
            $table->foreignId('bed_id')->constrained(table: 'beds', column: 'id')->cascadeOnUpdate();
            $table->foreignId('room_id')->constrained(table: 'rooms', column: 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('count');
            $table->primary(['bed_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bed_room');
    }
};
