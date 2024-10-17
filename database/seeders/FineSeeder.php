<?php

namespace Database\Seeders;

use App\Models\Fine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Fine::create([
                'member_id' => rand(1, 10),
                'object' => $faker->sentence,
                'amount' => rand(1000, 100000),
                'author' => $faker->userName,
                'status' => rand(0, 1)
            ]);
        }
    }
}
