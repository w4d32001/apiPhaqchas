<?php

namespace Database\Seeders\Sport;

use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sport::create([
            'name' => 'Voley',
            'description' => 'asdadas',
            'price_morning' => 20,
            'price_evening' => 25,
        ]);
    }
}
