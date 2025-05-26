<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        
        $table->unsignedBigInteger('passenger_id');
        $table->foreign('passenger_id')->references('id')->on('passengers')->onDelete('cascade');

        $table->unsignedBigInteger('flight_id');
        $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');

        $table->string('booking_reference')->unique();
        $table->dateTime('booking_date');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
