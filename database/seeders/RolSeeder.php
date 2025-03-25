<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Role::create([
             'name' => 'Administrador',
         ]);
         Role::create([
             'name' => 'trabajador',
         ]);
         Role::create([
             'name' => 'usuario',
        ]);
        
    }
}
