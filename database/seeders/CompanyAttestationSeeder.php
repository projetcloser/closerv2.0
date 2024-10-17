<?php

namespace Database\Seeders;

use App\Models\CompanyAttestation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyAttestationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 1; $i++) {
            $item = new CompanyAttestation();

            $item->created([
                'member_id' => 1,
                'year' => $faker->year,
                'company_id' => (int)($i + 1),
                'motif' => $faker->paragraph
            ]);
        }
    }
}
