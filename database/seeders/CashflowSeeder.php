<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashflowSeeder extends Seeder
{
    /**
     * Seed the database with initial cashflows.
     */
    public function run()
    {
        DB::table('cashflows')->insert([
            [
                'code' => 'CF001',
                'name' => 'Initial Cashflow',
                'balance' => 1000,
                'personnel_id' => 1, // Remplace par une ID valide
                'open_close' => 0,
            ],
            // Ajoute d'autres cashflows si nécessaire
        ]);
    }
}
