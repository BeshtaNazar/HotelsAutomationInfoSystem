<?php

use App\Enums\HotelStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('are_children_allowed');
            $table->boolean('are_pets_allowed');
            $table->time('arrival_time_from');
            $table->time('arrival_time_to');
            $table->time('departure_time_from');
            $table->time('departure_time_to');
            $table->integer('cancelation_policy_days');
            $table->integer('building_number');
            $table->string('street');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->string('iban');
            $table->string('status')->default(HotelStatus::NEW );
            $table->foreignId('user_id')->constrained(table: 'users', column: 'id')->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
