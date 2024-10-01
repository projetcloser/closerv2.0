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
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Member::create([
                'matricule' => $faker->macAddress,
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'email' => $faker->email,
                'order_number' => $faker->imei,
                'phone' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'folder' => $faker->filePath("tmp/file.pdf"),
                'picture' => $faker->linuxPlatformToken,
                'debt' => $faker->numberBetween(1000, 99999),
            ]);
        }
    }
}
