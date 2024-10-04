<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalCertificate;
use App\Models\Cashflow;
use App\Models\Member;
use App\Models\Personnel;

class PersonalCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashflow = Cashflow::first();
        $member = Member::first();
        $personnel = Personnel::first();

        $numeroref = PersonalCertificate::count() + 1;
        $month = now()->format('m');
        $year = now()->format('y');

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 3; $i++) {
            PersonalCertificate::create([
                'cashflow_id' => $cashflow->id,
                'member_id' => $member->id,
                'personnel_id' => $personnel->id,
                'ref_dem_part' => 'N° ' . str_pad($numeroref, 4, '0', STR_PAD_LEFT) . ' / ' . $month . ' /Pdt/SG/ONIGC/' . $year,
                'amount' => 0,
                'status' => 'envoyer',
                'author' => 'John Doe',
                'open_close' => 0,
                'date_certification' => now(),
                'object' => $faker->text
            ]);
        }
    }
}
