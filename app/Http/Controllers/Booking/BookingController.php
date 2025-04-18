<?php

namespace App\Http\Controllers\Booking;

use App\Exports\BookingsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\ChangeRequest;
use App\Http\Requests\Booking\StoreRequest;
use App\Http\Requests\Booking\UpdateRequest;
use App\Models\Booking;
use App\Models\Field;
use App\Models\Sport;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();

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

            $fullStartTime = $bookingDate->copy()->setTime($startTime->hour, $startTime->minute);

            $existingBooking = Booking::where('field_id', $validation['field_id'])
                ->where('booking_date', $bookingDate->toDateString())
                ->where('start_time', $startTime->format('H:i:s'))
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

            $priceRequired = ($startTime->hour < 15) ? $sport->price_morning : $sport->price_evening;

            if ($validation['total'] == $priceRequired) {
                $validation['status'] = 'completado';
            } elseif ($validation['total'] > 0) {
                $validation['status'] = 'reservado';
            } else {
                $validation['status'] = 'en espera';
            }

            // Crear la reserva
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

    public function update(UpdateRequest $request, Booking $booking)
    {
        try {
            $validated = $request->validated();
            $booking->update($validated);
            return $this->sendResponse($booking, 'Reserva actualizada');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }

    public function promotions(int $id){
        try{

            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'promoción']);
            return $this->sendResponse($booking, 'Promoción realizada');

        }catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function deleteBooking(int $id){
        try{

            $booking = Booking::findOrFail($id);
            $booking->update(['status' => 'eliminada']);
            return $this->sendResponse($booking, 'Reserva eliminada');

        }catch(\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

    public function change(ChangeRequest $request, int $id)
    {
        try {
            $validated = $request->validated();
            $booking = Booking::findOrFail($id);
            $booking->update($validated);
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
            $status = ($newTotal >= $paymentPrice) ? 'completado' : 'reservado';

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

            $user = User::findOrFail($booking->user_id);
            $user->update([
                'faults' => $user->faults + 1,
            ]);

            $booking->delete();

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
                    ->join('sports', 'bookings.sport_id', '=', 'sports.id')
                    ->select(
                        'bookings.*',
                        'users.name as user_name',
                        'users.id as user_id',
                        'sports.price_evening',
                        'sports.price_morning'
                    )
                    ->where('field_id', $courtId)
                    ->where('start_time', $hour)
                    ->whereRaw('DAYOFWEEK(booking_date) = ?', [$dayNumber])
                    ->whereBetween('booking_date', [$start, $end])
                    ->first();
                $price = null;
                if ($booking) {
                    $hourCarbon = Carbon::parse($hour);
                    $price = ($hourCarbon->hour < 15) ? $booking->price_morning : $booking->price_evening;
                }

                $row['days'][] = [
                    'day_name' => $dayName,
                    'status' => $booking->status ?? "disponible",
                    'booking_details' => $booking ? [
                        'id' => $booking->id,
                        'id_user' => $booking->user_id,
                        'user_name' => $booking->user_name,
                        'yape' => $booking->yape ?? 0,
                        'price' =>  $booking->price,
                        'total' => $booking->price + $booking->yape,
                        'price_sport' => $price
                    ] : null,
                ];
            }

            return $row;
        });

        return $this->sendResponse($results, "Tabla de reservas");
    }

    public function bookingsForLandingPage($courtId, $start)
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
                    ->where('field_id', $courtId)
                    ->whereRaw('TIME(start_time) = ?', [$hour])
                    ->whereDate('booking_date', $date)
                    ->first();

                $status = $booking ? $booking->status : 'disponible';

                $row[$date] = $status;
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
            DB::raw('SUM(price + yape) as total'),
            DB::raw('SUM(price) as price'),
            DB::raw('SUM(yape) as yape')
        )
        ->whereBetween('booking_date', [$start, $end])
        ->groupBy('date', 'field_id')
        ->get()
        ->groupBy('date');

    $results = collect($dates)->map(function ($date) use ($fields, $bookings) {
        $dateStr = $date->format('Y-m-d');
        $fieldsData = collect($fields)->map(function ($fieldName, $fieldId) use ($bookings, $dateStr) {
            $booking = collect($bookings[$dateStr] ?? [])->firstWhere('field_id', $fieldId);
            return [
                'field' => $fieldName,
                'total' => ($booking->price ?? 0) + ($booking->yape ?? 0),
                'price' => $booking->price ?? 0,
                'yape' => $booking->yape ?? 0,
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
        $fieldBookings = $bookings->flatten(1)->where('field_id', $fieldId);
        return [
            $fieldName => [
                'total' => $fieldBookings->sum('total'),
                'total_price' => $fieldBookings->sum('total_price'),
                'total_quantity' => $fieldBookings->sum('total_quantity'),
            ]
        ];
    });

    return $this->sendResponse([
        'bookings' => $results->toArray(),
        'fieldTotals' => $fieldTotals,
    ], "Tabla de reservas para el mes");
}


    public function exportBookingsToExcel($month, $year)
    {
        $response = $this->bookingsForAdmiMonth($month, $year);
        $data = $response->getData(true);
        return Excel::download(new BookingsExport($data), "reservas_{$month}_{$year}.xlsx");
    }
}
