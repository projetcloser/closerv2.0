<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Event::create([
                'title' => $faker->text,
                'place' => $faker->address,
                'participants' => $faker->numberBetween(5, 250),
                'price' => "10000",
                'start_date' => $faker->date,
                'end_date' => $faker->date,
                'author' => $faker->userName
            ]);
        }
    }
}
