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
       Schema::create('flights', function (Blueprint $table) {
    $table->id();
    $table->string('flight_number')->unique();
    $table->string('departure_airport');
    $table->string('arrival_airport');
    $table->dateTime('departure_time');
    $table->dateTime('arrival_time');
    $table->string('airline');
    $table->integer('capacity');
    $table->decimal('price', 10, 2);
    $table->enum('status', ['Active', 'Inactive']);
    $table->string('aircraft_type');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
