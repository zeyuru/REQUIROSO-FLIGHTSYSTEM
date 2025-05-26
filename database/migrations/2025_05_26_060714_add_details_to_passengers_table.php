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
    Schema::table('passengers', function (Blueprint $table) {
        $table->string('passport_number')->unique()->after('email');
        $table->string('nationality')->after('passport_number');
        $table->date('dob')->nullable()->after('nationality');
        $table->string('phone_number')->after('dob');
    });
}

public function down()
{
    Schema::table('passengers', function (Blueprint $table) {
        $table->dropColumn(['passport_number', 'nationality', 'dob', 'phone_number']);
    });
}

};
