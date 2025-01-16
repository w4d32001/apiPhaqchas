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
            "field_type_id" => 1,
            "name" => "Campo 4",
            "price_morning" => "15",
            "price_evening" => "20"
        ]);

        Field::create([
            "field_type_id" => 1,
            "name" => "Campo 4",
            "price_morning" => "15",
            "price_evening" => "20"
        ]);

        Field::create([
            "field_type_id" => 1,
            "name" => "Campo 4",
            "price_morning" => "15",
            "price_evening" => "20"
        ]);

        Field::create([
            "field_type_id" => 1,
            "name" => "Campo 4",
            "price_morning" => "15",
            "price_evening" => "20"
        ]);
    }
}
