<?php

namespace Database\Seeders;

use App\Http\Controllers\API\CashflowController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'id_perso' => 1,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        // User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
            CitySeeder::class,
            CompaniesSeeder::class,
            MembersSeeder::class,
            MemberAcademicStatesSeeder::class,
            StampsSeeder::class,
            PersonnelSeeder::class,
            CashflowSeeder::class,
            CotisationSeeder::class,
            PersonalCertificateSeeder::class,
            RoleSeeder::class,
            UserRoleSeeder::class,
        ]);


    }
}
