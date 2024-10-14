<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Définir les valeurs possibles pour les colonnes qui utilisent des enums
        $genders = ['MALE', 'FEMALE'];
        $contractTypes = ['CDD', 'CDI', 'TEMPORAIRE'];

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $genderIndex = array_rand($genders);
            $contractTypeIndex = array_rand($contractTypes);

            Staff::create([
                'statut' => 1,  // 1 pour ACTIF
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,  // Assurer l'unicité de l'email
                'date_card_validity' => '2025-12-31',
                'phone' => $faker->phoneNumber,
                'phone_2' => $faker->phoneNumber,
                'father_name' => $faker->firstNameMale,
                'father_phone' => $faker->phoneNumber,
                'mother_name' => $faker->firstNameFemale,
                'birthday' => '1990-01-01',
                'place_birth' => 'Yaoundé',
                'profession' => 'Doctor',
                'gender' => $genders[$genderIndex],
                'contract_type' => $contractTypes[$contractTypeIndex], // Valeur choisie parmi les types de contrat valides
                'marital_status' => 'Married',
                'position' => 'Head of Department',
                'num_children' => 2,
                'open_close' => 0,  // 0 par défaut
                'city_id' => 1,  // S'assurer que ces IDs existent
                'country_id' => 1,
                'neighbourhood' => $faker->address,  // Ajouter un champ pour le quartier
                'attachment_file' => $faker->filePath("tmp/file.pdf")
            ]);
        }
    }
}
