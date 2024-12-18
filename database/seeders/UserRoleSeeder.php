<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer l'utilisateur
        $user = User::where('email', 'test@example.com')->first();

        // Récupérer le rôle administrateur
        $adminRole = Role::where('name', 'administrateur')->first();


        // Associer l'utilisateur au rôle administrateur
        if ($user && $adminRole) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $adminRole->id,
            ]);
        }
    }
}
