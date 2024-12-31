<?php

namespace Database\Seeders;

use App\Models\Stamp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StampsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 1; $i++) {
            $item = new Stamp();

            $item->created([
                'member_id' => 1,
                'receipt_number' => 'RC001',
                'status' => 1,
                'author' => 'John Doe',
                'city_id' => 1,
                'phone' => '0788888888',
                'year' => '2024',
            ]);
        }
    }
}
