<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $strings = array(
            'PUBLIC',
            'PRIVEE',
        );

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 2; $i++) {
            $cityId = rand(1, 2);
            $typeIndex = array_rand($strings);
            Company::create([
                'social_reason' => $faker->company,
                'author' => $faker->name,
                'phone' => $faker->phoneNumber,
                'nui' => $faker->imei,
                'company_type' => $strings[$typeIndex],
                'country_id' => 1,
                'city_id' => $cityId,
                'company_categorie' => 'Entreprise',
                'contact_person' => $faker->name,
                'contact_person_phone' => $faker->phoneNumber,
                'neighborhood' => $faker->address
            ]);
        }
    }
}
