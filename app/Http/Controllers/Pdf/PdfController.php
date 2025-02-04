<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\User;

class PdfController extends Controller
{
    public function pdfUsers()
    {
        $users = User::where('rol_id', 3)->get();
        $date = now()->toDateString();
        $pdf = Pdf::loadView('pdf.user', compact(['users', 'date']));
        return $pdf->download('reporte_usuarios_' . $date . '.pdf');
        //return view('pdf.user', compact(['users', 'date']));
    }

    public function exportBookingsForMonthPf($month, $year)
    {
        $bookingController = new BookingController();
        $date = now()->toDateString();

        $response = $bookingController->bookingsForAdmiMonth($month, $year);

        $data = $response->original;

        $bookings = $data['data'];

        //return response()->json($bookingsData['bookings']);
        $bookingsData = $bookings['bookings'];
        //return view('pdf.month', compact(['bookingsData', 'date']));
        $pdf = Pdf::loadView('pdf.month', compact(['bookingsData', 'date']));
        return $pdf->download('reporte_mes_' . $date . '.pdf');
    }
}
