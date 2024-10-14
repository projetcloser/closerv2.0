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
        // User::factory(10)->create();
        $this->call(CountrySeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CompaniesSeeder::class);
        $this->call(MembersSeeder::class);
        $this->call(MemberAcademicStatesSeeder::class);
        $this->call(StampsSeeder::class);
        $this->call(StaffSeeder::class);
        $this->call(CashflowSeeder::class);
        $this->call(CotisationSeeder::class);
        $this->call(PersonalCertificateSeeder::class);
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
