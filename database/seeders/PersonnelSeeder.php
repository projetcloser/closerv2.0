<?php

namespace Database\Seeders;

use App\Models\Personnel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonnelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $strings = array(
            'Male',
            'Female',
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $typeIndex = array_rand($strings);
            Personnel::create([
                'statut' => 'Active',
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
                'genre' => $strings[$typeIndex],
                'contract_type' => 'Permanent',
                'marital_status' => 'Married',
                'position' => 'Head of Department',
                'num_children' => 2,
                'open_close' => 0,
                'city_id' => 1,
                'country_id' => 1,
                'neighbourhood' => $faker->address,
                'attachment_file' => $faker->filePath("tmp/file.pdf")
            ]);
        }
    }
}
