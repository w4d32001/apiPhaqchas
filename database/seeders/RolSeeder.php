<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'name' => 'Administrador',
            'description' => 'Tiene acceso completo al sistema.',
        ]);
        Rol::create([
            'name' => 'Usuario',
            'description' => 'Tiene acceso limitado al sistema.',
        ]);
    }
}
