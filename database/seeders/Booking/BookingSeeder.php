<?php

namespace Database\Seeders\Booking;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
    Booking::create([
        'user_id' => 1,
        'field_id' => 1,
        'booking_date' => "2025-01-15",
        'start_time' => "14:00",
        'end_time' => "15:00",
        'status' => 'en espera',
        'precio' => 0, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 1,
        'booking_date' => "2025-01-03",
        'start_time' => "19:00",
        'end_time' => "20:00",
        'status' => 'Reservado',
        'precio' => 20, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 2,
        'booking_date' => "2025-01-16",
        'start_time' => "08:00",
        'end_time' => "09:00",
        'status' => 'en espera',
        'precio' => 0, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 3,
        'booking_date' => "2025-01-15",
        'start_time' => "15:00",
        'end_time' => "16:00",
        'status' => 'Reservado',
        'precio' => 20, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 4,
        'booking_date' => "2025-01-15",
        'start_time' => "11:00",
        'end_time' => "12:00",
        'status' => 'en espera',
        'precio' => 0, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 1,
        'booking_date' => "2025-01-17",
        'start_time' => "12:00",
        'end_time' => "13:00",
        'status' => 'Reservado',
        'precio' => 20, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 1,
        'booking_date' => "2025-01-17",
        'start_time' => "15:00",
        'end_time' => "16:00",
        'status' => 'Reservado',
        'precio' => 20, 
    ]);

    Booking::create([
        'user_id' => 1,
        'field_id' => 2,
        'booking_date' => "2025-01-18",
        'start_time' => "09:00",
        'end_time' => "10:00",
        'status' => 'en espera',
        'precio' => 0, 
    ]);
}
}
