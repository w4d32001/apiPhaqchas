<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Field;
use App\Models\Sport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index()
    {
        try {
            // Obtener los campos
            $fields = Field::select('id', 'status', 'name', 'image', 'description')->get();

            // Obtener anuncios activos
            $announcements = Announcement::select('id', 'title', 'image', 'description')
                ->where('status', 1)->get();

            // Obtener los deportes
            $sports = Sport::select('id', 'name', 'description', 'price_morning', 'price_evening', 'image')->get();

            return view('home', compact('fields', 'announcements', 'sports'));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al cargar los datos'], 500);
        }
    }

    public function bookingsForLandingPage($id, $start)
    {
        $hours = collect(range(8, 21))->map(function ($hour) {
            return sprintf('%02d:00:00', $hour);
        });

        $start = Carbon::parse($start);

        // Generar un array de fechas para los próximos 7 días
        $daysOfWeek = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $start->copy()->addDays($i);
            $daysOfWeek[$day->format('Y-m-d')] = $day->format('l'); // Usa el nombre del día si lo necesitas
        }

        $results = [];

        foreach ($hours as $hour) {
            $row = [
                'hour' => Carbon::parse($hour)->format('h:i A') . ' - ' . Carbon::parse($hour)->addHour()->format('h:i A'),
            ];

            foreach ($daysOfWeek as $date => $dayName) { // Usamos la fecha directamente
                $booking = DB::table('bookings')
                    ->where('field_id', $id)
                    ->whereRaw('TIME(start_time) = ?', [$hour])
                    ->whereDate('booking_date', $date)
                    ->first();

                $status = $booking ? $booking->status : 'disponible';

                $row[$date] = $status;
            }

            $results[] = $row;
        }

        return response()->json(['data' => $results]);
    }
}
