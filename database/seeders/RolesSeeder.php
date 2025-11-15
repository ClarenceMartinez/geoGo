<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // 👈 ESTA LÍNEA ES LA QUE FALTABA


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Super Admin'],
            ['id' => 2, 'name' => 'Admin Empresa'],
            ['id' => 3, 'name' => 'Manager'],
            ['id' => 4, 'name' => 'Empleado'],
        ]);
    }
}
