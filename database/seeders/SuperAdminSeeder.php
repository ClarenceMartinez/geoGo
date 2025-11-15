<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;                 // 👈 Importar el modelo User
use Illuminate\Support\Facades\Hash; // 👈 Importar Hash


class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@geogo.com',
            'password' => Hash::make('Admin123*'),
            'role_id' => 1,  // Super Admin
            'company_id' => null,
            'branch_id' => null,
        ]);
    }
}
