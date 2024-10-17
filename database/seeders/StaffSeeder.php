<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $strings = array(
            'MALE',
            'FEMALE',
        );

        $cTypes = array(
            'CDD',
            'CDI',
            'TEMPORAIRE'
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $typeIndex = array_rand($strings);
            $cTypeIndex = array_rand($cTypes);
            Staff::create([
                'statut' => rand(0, 1),
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'email' => $faker->email,
                'date_card_validity' => '2025-12-31',
                'phone' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'father_name' => $faker->firstNameMale,
                'father_phone' => $faker->lastName . ' ' . $faker->phoneNumber,
                'mother_name' => $faker->lastName . ' ' . $faker->firstNameMale,
                'birthday' => '1990-01-01',
                'place_birth' => 'Yaoundé',
                'profession' => 'Doctor',
                'gender' => $strings[$typeIndex],
                'contract_type' => $cTypes[$cTypeIndex],
                'marital_status' => 'Married',
                'position' => 'Head of Department',
                'num_children' => 2,
                'open_close' => 0,
                'city_id' => 1,
                'country_id' => 1,
                'neighborhood' => $faker->address,
                'attachment_file' => $faker->filePath("tmp/file.pdf")
            ]);
        }
    }
}
