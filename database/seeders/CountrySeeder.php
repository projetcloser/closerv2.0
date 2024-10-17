<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();
        $countriesRecords = [
            [
                'id' => 1,
                'code' => 'CM',
                'name' => 'Cameroun'
            ]
        ];
        DB::table('countries')->insert($countriesRecords);
    }
}
