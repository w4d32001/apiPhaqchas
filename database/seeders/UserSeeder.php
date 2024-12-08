<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admi',
            'surname' => 'nistrador',
            'email' => 'correo@example.com',
            'password' => Hash::make('12345678'),
            'dni' => '12345678',
            'phone' => '987654321',
            'status' => 1,
            'rol_id' => 1, 
        ]);
    }
}
