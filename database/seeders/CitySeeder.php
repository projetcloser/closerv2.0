<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            ['country_id' => 1, 'name' => 'Yaoundé', 'status' => 1],
            ['country_id' => 1, 'name' => 'Douala', 'status' => 1],
        ]);
    }
}
