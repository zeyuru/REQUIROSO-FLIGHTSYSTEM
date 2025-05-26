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
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('email')->unique();
        $table->string('password');
        $table->unsignedBigInteger('role_id');
        $table->unsignedBigInteger('status_id'); // ✅ Add this line

        // Foreign Keys
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade'); // ✅ Add this

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
