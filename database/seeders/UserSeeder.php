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
        // User::create([
        //     'name' => 'Aron',
        //     'surname' => 'Pizarro',
        //     'password' => Hash::make('12345678'),
        //     'dni' => '12345678',
        //     'phone' => '912365478',
        //     'status' => 1,
        //     'rol_id' => 1, 
        // ]);
        // User::create([
        //     'name' => 'traba',
        //     'surname' => 'jador',
        //     'password' => Hash::make('12345678'),
        //     'dni' => '98765432',
        //     'phone' => '123456789',
        //     'status' => 1,
        //     'rol_id' => 2, 
        // ]);
        User::create([
            'name' => 'w4d3',
            'surname' => 'nistrador',
            'password' => Hash::make('12345678'),
            'dni' => '12345673',
            'phone' => '987654323',
        ]);
        User::create([
            'name' => 'carlos',
            'surname' => 'sanchez',
            'password' => Hash::make('12345678'),
            'dni' => '11345673',
            'phone' => '987644323',
        ]);
        User::create([
            'name' => 'Pedro',
            'surname' => 'Gonzales',
            'password' => Hash::make('12345678'),
            'dni' => '12346673',
            'phone' => '987654323',
        ]);
        User::create([
            'name' => 'Jhon',
            'surname' => 'Heranndez',
            'password' => Hash::make('12345678'),
            'dni' => '12346673',
            'phone' => '987554323',
        ]);
        User::create([
            'name' => 'Giselle',
            'surname' => 'Ramirez',
            'password' => Hash::make('12345678'),
            'dni' => '12345675',
            'phone' => '997654323',
        ]);
        User::create([
            'name' => 'Gloria',
            'surname' => 'Perez',
            'password' => Hash::make('12345678'),
            'dni' => '12395673',
            'phone' => '977654323',
        ]);
        User::create([
            'name' => 'Rafaela',
            'surname' => 'Espinoza',
            'password' => Hash::make('12345678'),
            'dni' => '12785673',
            'phone' => '988554323',
        ]);
        User::create([
            'name' => 'Carla',
            'surname' => 'Gomez',
            'password' => Hash::make('12345678'),
            'dni' => '12825673',
            'phone' => '927654323',
        ]);
        
    }
}

