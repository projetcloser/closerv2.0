<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use App\Models\PersonalCertificate;
use App\Models\Cashflow;
use App\Models\Member;

class PersonalCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vérifie qu'il y a au moins un enregistrement dans chaque table
        $cashflow = Cashflow::first();
        $member = Member::first();
        $personnel = Staff::first();

        if (!$cashflow || !$member || !$personnel) {
            // Gérer l'absence d'enregistrements nécessaires
            // Par exemple, tu peux lancer une exception ou faire un log
            return; // Sortir si l'un des enregistrements est manquant
        }

        // Compter les certificats personnels existants pour générer la référence
        $numeroref = PersonalCertificate::count() + 1;
        $month = now()->format('m');
        $year = now()->format('y');

        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 3; $i++) {
            PersonalCertificate::create([
                'cashflow_id' => $cashflow->id,
                'member_id' => $member->id,
                'staff_id' => $personnel->id,
                'ref_dem_part' => 'N° ' . str_pad($numeroref, 4, '0', STR_PAD_LEFT) . ' / ' . $month . ' /Pdt/SG/ONIGC/' . $year,
                'amount' => 0,  // Valeur par défaut
                'status' => 1,  // Statut par défaut : non payé
                'author' => 'John Doe',
                'open_close' => 0,  // Valeur par défaut
                'certification_date' => now()->toDateString(),  // Format de date
                'object' => $faker->text(50) // Limiter la taille du texte
            ]);
        }
    }
}
