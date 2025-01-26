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
        'sport_id' => 1,        
        'booking_date' => "2025-01-27",
        'start_time' => "11:00",
        'end_time' => "12:00",
        'status' => 'reservado',
        'price' => 0, 
        'yape' => 10,
        'total' => 10
    ]);
    // Booking::create([
    //     'user_id' => 1,
    //     'field_id' => 1,
    //     'sport_id' => 1,        
    //     'booking_date' => "2025-01-28",
    //     'start_time' => "09:00",
    //     'end_time' => "10:00",
    //     'status' => 'reservado',
    //     'price' => 15, 
    //     'yape' => 5,
    //     'total' => 20
    // ]);
}
}
