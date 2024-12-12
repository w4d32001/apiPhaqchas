<?php

namespace Database\Seeders\Field;

use App\Models\FieldType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldType::create([
            "name"=> "Basquet",
        ]);
        FieldType::create([
            "name"=> "Voley",
        ]);
        FieldType::create([
            "name"=> "Futsal",
        ]);
        FieldType::create([
            "name"=> "Billar",
        ]);

    }
}
