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
        Personnel::create([
            'statut' => 'Active',
            'lastname' => 'Doe',
            'firstname' => 'John',
            'email' => 'johndoe@example.com',
            'date_card_validity' => '2025-12-31',
            'phone' => '123456789',
            'father_name' => 'John Doe Sr.',
            'father_phone' => '987654321',
            'mother_name' => 'Jane Doe',
            'birthday' => '1990-01-01',
            'place_birth' => 'Yaoundé',
            'profession' => 'Doctor',
            'genre' => 'Male',
            'contract_type' => 'Permanent',
            'marital_status' => 'Married',
            'position' => 'Head of Department',
            'num_children' => 2,
            'open_close' => 0,
            'city_id' => 1,
            'country_id' => 1,
        ]);
    }
}
