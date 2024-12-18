<?php

namespace Database\Seeders;

use App\Models\MemberAcademicState;
use Illuminate\Database\Seeder;

class MemberAcademicStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strings = array(
            'male',
            'female',
        );



        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $typeIndex = array_rand($strings);
            $item = new MemberAcademicState();

            $item->created([
                'member_id' => (int)($i + 1),
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'username' => $faker->userName,
                'email' => $faker->email,
                'birthday' => (string)($faker->dateTimeBetween('1950-01-01', '2000-12-31')
                    ->format('Y-m-d')),
                'gender' => $strings[$typeIndex],
                'address' => $faker->address,
                'country_id' => (int)($i + rand(1, 10)),
                'city_id' => (int)($i + rand(1, 10)),
                'neighborhood' => $faker->streetAddress,
                'phone' => $faker->phoneNumber,
                'biography' => $faker->sentence,
                'avatar64' => $faker->randomAscii
            ]);

            // print_r([
            //     'member_id' => $i + 1,
            //     'lastname' => $faker->lastName,
            //     'firstname' => $faker->firstName,
            //     'username' => $faker->userName,
            //     'email' => $faker->email,
            //     'birthday' => $faker->dateTimeBetween('1950-01-01', '2000-12-31')
            //         ->format('Y-m-d'),
            //     'gender' => $strings[$typeIndex],
            //     'address' => $faker->address,
            //     'country_id' => $i + rand(1, 10),
            //     'city_id' => $i + rand(1, 10),
            //     'neighborhood' => $faker->streetAddress,
            //     'phone' => $faker->phoneNumber,
            //     'biography' => $faker->sentence,
            //     'avatar64' => base64_encode($faker->sentence)
            // ]);
        }
    }
}
