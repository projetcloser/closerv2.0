<?php

namespace Database\Seeders;


use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'membre',
            'administrateur',
            'receptionniste',
            'representant regional',
            'president',
            'secretaire general',
            'secretaire administrative',
            'responsable de communication',
            'responsable administratif',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
