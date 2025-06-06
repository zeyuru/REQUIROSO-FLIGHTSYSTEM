<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <- Add this lin

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       DB::table('user_statuses')->insert([
    ['status' => 'Active'],
    ['status' => 'Inactive'],
      ['status' => 'Suspended'],
]);

    }
}
