<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Seeders\Booking\BookingSeeder;
use Database\Seeders\Field\FieldSeeder;
use Database\Seeders\Field\FieldTypeSeeder;
use Database\Seeders\Sport\SportSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolSeeder::class,
            // UserSeeder::class,
            // FieldSeeder::class,
            //SportSeeder::class,
            //BookingSeeder::class
        ]);
    }
}
