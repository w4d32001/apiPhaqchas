<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreRequest;
use App\Models\Booking;
use App\Models\Field;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::all();
            return $this->sendResponse($bookings, "Lista de reservas");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $validation = $request->all();
            $validation['total'] = ($validation['price'] ?? 0) + ($validation['yape'] ?? 0);

            $sport = Sport::findOrFail($validation['sport_id']);
            $field = Field::findOrFail($validation['field_id']);

            $startTime = Carbon::createFromFormat('H:i', $validation['start_time']);

            $bookingDate = Carbon::createFromFormat('Y-m-d', $validation['booking_date']);

            $existingBooking = Booking::where('field_id', $validation['field_id'])
                ->whereDate('start_time', $bookingDate->toDateString())
                ->whereTime('start_time', $startTime->toTimeString())
                ->exists();

            if ($existingBooking) {
                return $this->sendError('Ya existe una reserva a esa hora y en ese campo.');
            }

            if ($startTime->hour < 15) {
                if ($validation['total'] > $sport->price_morning) {
                    return $this->sendError('El precio total excede al precio de la cancha en la mañana.');
                }
            } else {
                if ($validation['total'] > $sport->price_evening) {
                    return $this->sendError('El precio total excede al precio de la cancha en la tarde.');
                }
            }

            if ($validation['total'] > 0) {
                $validation['status'] = 'reservado';
            } else {
                $validation['status'] = 'en espera';
            }

            $booking = Booking::create($validation);
            return $this->sendResponse($booking, "Reserva creada", 'success', 201);
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

    public function update(StoreRequest $request, Booking $booking)
    {
        try {
            $validation = $request->all();
            $validation['total'] = ($validation['price'] ?? 0) + ($validation['yape'] ?? 0);

            $sport = Sport::findOrFail($validation['sport_id']);

            $startTime = Carbon::createFromFormat('H:i', $validation['start_time']);

            if ($startTime->hour < 15) {
                if ($validation['total'] > $sport->price_morning) {
                    return $this->sendError('El precio total excede al precio de la cancha en la mañana.');
                }
            } else {
                if ($validation['total'] > $sport->price_evening) {
                    return $this->sendError('El precio total excede al precio de la cancha en la tarde.');
                }
            }

            if ($validation['total'] > 0) {
                $validation['status'] = 'reservado';
            } else {
                $validation['status'] = 'en espera';
            }

            $booking->update($validation);
            return $this->sendResponse($booking, 'Reserva actualizada');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
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

    public function completePayment($id, Request $request)
    {
        try {
            $booking = Booking::findOrFail($id);

            $sport = DB::table('sports')
                ->select('price_morning', 'price_evening')
                ->where('id', $booking->sport_id)
                ->first();

            if (!$sport) {
                return $this->sendError('No se encontró información del deporte asociado.');
            }

            $price = $request->input('price');
            $yape = $request->input('yape');

            if (empty($price) && empty($yape)) {
                return $this->sendError('Debe proporcionar al menos un tipo de pago (price o yape).');
            }

            $paymentPrice = ($booking->start_time < '15:00:00') ? $sport->price_morning : $sport->price_evening;

            $remainingAmount = $paymentPrice - ($booking->price + $booking->yape);

            if ($remainingAmount <= 0) {
                return $this->sendError('El pago ya está completo.');
            }

            $totalPaid = 0;

            if (!empty($price)) {
                $totalPaid += $price;
            }

            if (!empty($yape)) {
                $totalPaid += $yape;
            }

            if ($totalPaid > $remainingAmount) {
                return $this->sendError('El monto ingresado excede la cantidad restante a pagar.');
            }

            if (!empty($price)) {
                $booking->update([
                    'price' => $booking->price + $price,
                ]);
            }

            if (!empty($yape)) {
                $booking->update([
                    'yape' => $booking->yape + $yape,
                ]);
            }

            $newTotal = $booking->price + $booking->yape;
            $status = ($newTotal >= $paymentPrice) ? 'completado' : 'en espera';

            $booking->update([
                'status' => $status,
                'total' => $newTotal,
            ]);

            return response()->json([
                'message' => 'Pago completado exitosamente.',
                'total' => $newTotal,
                'paymentType' => !empty($price) ? 'contado' : 'Yape',
                'remainingAmount' => $paymentPrice - $newTotal
            ]);
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }



    public function cancelBooking($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            $booking->update([
                'status' => 'cancelado',
            ]);

            $user = User::findOrFail($booking->user_id);
            $user->update([
                'faults' => $user->faults + 1,
            ]);

            return $this->sendResponse($booking, 'Reserva cancelada correctamente');
        } catch (\Exception $e) {
            return $this->sendError('Error: ' . $e->getMessage());
        }
    }

    public function bookingsForAdmi($courtId, $start, $end)
    {
        $hours = collect(range(8, 21))->map(function ($hour) {
            return sprintf('%02d:00:00', $hour);
        });

        $daysOfWeek = [
            2 => 'Lunes',
            3 => 'Martes',
            4 => 'Miércoles',
            5 => 'Jueves',
            6 => 'Viernes',
            7 => 'Sábado',
            1 => 'Domingo',
        ];

        $results = collect($hours)->map(function ($hour) use ($courtId, $start, $end, $daysOfWeek) {
            $row = [
                'hour_range' => [
                    'start' => Carbon::parse($hour)->format('h:i A'),
                    'end' => Carbon::parse($hour)->addHour()->format('h:i A'),
                ],
                'days' => [],
            ];

            foreach ($daysOfWeek as $dayNumber => $dayName) {
                $booking = DB::table('bookings')
                    ->join('users', 'bookings.user_id', '=', 'users.id')
                    ->select(
                        'bookings.*',
                        'users.name as user_name',
                        'users.id as user_id'
                    )
                    ->where('field_id', $courtId)
                    ->where('start_time', $hour)
                    ->whereRaw('DAYOFWEEK(booking_date) = ?', [$dayNumber])
                    ->whereBetween('booking_date', [$start, $end])
                    ->first();

                $row['days'][] = [
                    'day_name' => $dayName,
                    'status' => $booking->status ?? "disponible",
                    'booking_details' => $booking ? [
                        'id' => $booking->id,
                        'id_user' => $booking->user_id,
                        'user_name' => $booking->user_name,
                        'yape' => $booking->yape ?? 0,
                        'price' => $booking->price ?? 0,
                        'total' => $booking->total ?? 0,
                    ] : null,
                ];
            }

            return $row;
        });

        return $this->sendResponse($results, "Tabla de reservas");
    }

    public function bookingsForLandingPage($courtId, $start, $end)
    {

        $hours = collect(range(8, 21))->map(function ($hour) {
            return sprintf('%02d:00:00', $hour);
        });

        $daysOfWeek = [
            1 => 'Domingo',
            2 => 'Lunes',
            3 => 'Martes',
            4 => 'Miercoles',
            5 => 'Jueves',
            6 => 'Viernes',
            7 => 'Sabado',
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
                $status = $booking ? $booking->status : 'disponible';

                $row[$dayName] = $status;
            }


            $results[] = $row;
        }

        return $this->sendResponse($results, 'Lista de reservas para la landing page');
    }

    public function bookingsForAdmiMonth($month, $year)
    {
        $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $end = Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $dates = CarbonPeriod::create($start, $end)->toArray();

        $fields = DB::table('fields')->pluck('name', 'id');

        $bookings = DB::table('bookings')
            ->select(
                DB::raw('DATE(booking_date) as date'),
                'field_id',
                DB::raw('SUM(total) as total')
            )
            ->whereBetween('booking_date', [$start, $end])
            ->groupBy('date', 'field_id')
            ->get()
            ->groupBy('date');
        Log::info($bookings);

        $results = collect($dates)->map(function ($date) use ($fields, $bookings) {
            $dateStr = $date->format('Y-m-d');
            $fieldsData = collect($fields)->map(function ($fieldName, $fieldId) use ($bookings, $dateStr) {
                $booking = collect($bookings[$dateStr] ?? [])->firstWhere('field_id', $fieldId);
                return [
                    'field' => $fieldName,
                    'total' => $booking->total ?? 0,
                ];
            });

            $totalMonth = $fieldsData->sum('total');

            return [
                'date' => $dateStr,
                'fields' => $fieldsData->values()->toArray(),
                'totalMonth' => $totalMonth,
            ];
        });

        $fieldTotals = collect($fields)->mapWithKeys(function ($fieldName, $fieldId) use ($bookings) {
            $total = $bookings->flatten(1)->where('field_id', $fieldId)->sum('total');
            return [$fieldName => $total];
        });

        return $this->sendResponse([
            'bookings' => $results->toArray(),
            'fieldTotals' => $fieldTotals,
        ], "Tabla de reservas para el mes");
    }
}
