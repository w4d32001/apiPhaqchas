<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::all();
            return $this->sendResponse(['booking' => $bookings], "Lista de reservas");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        try {
            return $this->sendResponse(['booking' => $booking], 'Reserva encontrada');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function update(Request $request, Booking $booking)
    {
        //
    }

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return $this->sendResponse([], 'Reserva eliminada');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function getBookingsByHour()
    {
        $startOfNextWeek = Carbon::now()->next(Carbon::MONDAY);

        $endOfNextWeek = $startOfNextWeek->copy()->endOfWeek();

        $start = $startOfNextWeek->format('Y-m-d');
        $end = $endOfNextWeek->format('Y-m-d');

        $bookings = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE_FORMAT(start_time, "%H:00") AS hour'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 2 THEN users.name END) AS monday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 2 THEN total ELSE 0 END) AS monday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 2 THEN total ELSE 0 END) AS monday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 3 THEN users.name END) AS tuesday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 3 THEN total ELSE 0 END) AS tuesday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 3 THEN total ELSE 0 END) AS tuesday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 4 THEN users.name END) AS wednesday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 4 THEN total ELSE 0 END) AS wednesday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 4 THEN total ELSE 0 END) AS wednesday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 5 THEN users.name END) AS thursday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 5 THEN total ELSE 0 END) AS thursday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 5 THEN total ELSE 0 END) AS thursday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 6 THEN users.name END) AS friday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 6 THEN total ELSE 0 END) AS friday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 6 THEN total ELSE 0 END) AS friday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 7 THEN users.name END) AS saturday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 7 THEN total ELSE 0 END) AS saturday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 7 THEN total ELSE 0 END) AS saturday_total'),
                DB::raw('GROUP_CONCAT(DISTINCT CASE WHEN DAYOFWEEK(booking_date) = 1 THEN users.name END) AS sunday'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 1 THEN total ELSE 0 END) AS sunday_yape'),
                DB::raw('SUM(CASE WHEN DAYOFWEEK(booking_date) = 1 THEN total ELSE 0 END) AS sunday_total')
            )
            ->whereBetween('booking_date', [$start, $end])
            ->whereBetween('start_time', ['08:00:00', '22:00:00'])
            ->groupBy(DB::raw('DATE_FORMAT(start_time, "%H:00")'))
            ->orderBy(DB::raw('DATE_FORMAT(start_time, "%H:00")'))
            ->get();

        //return response()->json($bookings);
        return view('bookings.index', compact('bookings'));
    }

    public function test($courtId, $start, $end) {
       
        $hours = collect(range(8, 22))->map(function ($hour) {
            return sprintf('%02d:00:00', $hour);
        });
    
        $daysOfWeek = [
            2 => 'Lunes',
            3 => 'Martes',
            4 => 'Miercoles',
            5 => 'Jueves',
            6 => 'Viernes',
            7 => 'Sabado',
            1 => 'Domingo',
        ];
    
        $results = [];
    
        foreach ($hours as $hour) {
            $row = [
                'hour' => Carbon::parse($hour)->format('h:i A') . ' - ' . Carbon::parse($hour)->addHour()->format('h:i A'),
            ];
    
            foreach ($daysOfWeek as $dayNumber => $dayName) {
                $booking = DB::table('bookings')
                    ->where('field_id', $courtId)
                    ->where('start_time', $hour)
                    ->whereRaw('DAYOFWEEK(booking_date) = ?', [$dayNumber])
                    ->whereBetween('booking_date', [$start, $end])
                    ->first();
    
                $status = $booking && strtolower($booking->status) === 'reservado' ? 'Reservado' : 'Disponible';
    
                Log::info([
                    'field_id' => $courtId,
                    'hour' => $hour,
                    'day' => $dayName,
                    'booking_date' => $booking ? $booking->booking_date : 'N/A',
                    'status' => $status,
                    'start' => $start,
                    'end' => $end,
                ]);
    
                $row[$dayName] = $status;
            }
    
            $results[] = $row;
        }
    
        return response()->json($results);
    }
    
    
    
    
    
    
}
