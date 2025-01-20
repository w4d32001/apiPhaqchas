<?php

namespace Database\Seeders\Field;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            "name" => "Campo 1",
        ]);

        Field::create([
            "name" => "Campo 2",
        ]);

        Field::create([
            "name" => "Campo 3",
        ]);

        Field::create([
            "name" => "Campo 4",
        ]);
    }
}
