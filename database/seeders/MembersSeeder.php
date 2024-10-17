<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strings = array(
            'MALE',
            'FEMALE',
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $sexIndex = array_rand($strings);
            Member::create([
                'matricule' => $faker->macAddress,
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'gender' => $strings[$sexIndex],
                'city_id' => rand(1, 2),
                'email' => $faker->email,
                'order_number' => $faker->imei,
                'phone' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'folder' => $faker->filePath("tmp/file.pdf"),
                'picture' => $faker->filePath("tmp/pic.png"),
                'debt' => $faker->numberBetween(1000, 99999),
            ]);
        }
    }
}
