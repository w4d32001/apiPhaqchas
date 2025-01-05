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
            $validation = $request->all();
            $booking =  Booking::create($validation);
            return $this->sendResponse(['booking' => $booking], "Reserva creada", 'success', 201);
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

    public function update(StoreRequest $request, Booking $booking) {}

    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
            return $this->sendResponse([], 'Reserva eliminada');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function test1($courtId, $start, $end)
{
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
                ->join('users', 'bookings.user_id', '=', 'users.id')
                ->select(
                    'bookings.*',
                    'users.name as user_name'
                )
                ->where('field_id', $courtId)
                ->where('start_time', $hour)
                ->whereRaw('DAYOFWEEK(booking_date) = ?', [$dayNumber])
                ->whereBetween('booking_date', [$start, $end])
                ->first();

            $row[$dayName . '_status'] = $booking && strtolower($booking->status) === 'reservado' ? 'Reservado' : 'Disponible';
            $row[$dayName . '_user_name'] = $booking->user_name ?? null;
            $row[$dayName . '_yape'] = $booking->total ?? 0;
            $row[$dayName . '_total'] = $booking->total ?? 0;

        }

        $results[] = $row;
    }

    return response()->json($results);
}



    public function test($courtId, $start, $end)
    {

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
