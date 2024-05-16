<?php

use App\Enums\ReservationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date_from');
            $table->date('date_to');
            $table->text('message')->nullable();
            $table->string('status')->default(ReservationStatus::RESERVATED);
            $table->foreignId('room_id')->constrained(table: 'rooms', column: 'id')->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained(table: 'users', column: 'id')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
