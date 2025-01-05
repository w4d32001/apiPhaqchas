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
        'booking_date' => "2025-01-03",
        'start_time' => "19:00",
        'end_time' => "20:00",
        'status' => 'Reservado',
        'total' => 12, 
    ]);


    }
}
