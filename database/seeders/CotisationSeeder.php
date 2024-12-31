<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CotisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cotisations')->insert([
            [
                'cashflow_id' => 1, // Assure-toi que ces IDs existent
                'pay_year' => '2024-01-01',
                'ref_ing_cost' => 'RC001',
                'member_id' => 1,
                'amount' => 60000,
                'pay' => 60000,
                'author' => 'John Doe',
                'status' => 3,
                // 'staff_id' => 1,
                'open_close' => 0,
            ],
            // Ajoute plus de données si nécessaire
        ]);
    }
}
