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
            'password' => Hash::make('12345678'),
            'dni' => '12345678',
            'phone' => '987654321',
            'status' => 1,
            'rol_id' => 1, 
        ]);
        User::create([
            'name' => 'traba',
            'surname' => 'jador',
            'password' => Hash::make('12345678'),
            'dni' => '98765432',
            'phone' => '123456789',
            'status' => 1,
            'rol_id' => 2, 
        ]);
        User::create([
            'name' => 'w4d3',
            'surname' => 'nistrador',
            'password' => Hash::make('12345678'),
            'dni' => '12345673',
            'phone' => '987654323',
        ]);
    }
}
