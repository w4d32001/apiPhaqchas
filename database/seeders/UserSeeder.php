<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);

        // Crear el usuario
        $user = User::create([
            'name' => 'Admin',
            'surname' => 'admin',
            'password' => Hash::make('12345678'),
            'dni' => '12345678',
            'phone' => '912365478',
            'status' => 1,
        ]);

        $user->assignRole($adminRole);
    }
}

