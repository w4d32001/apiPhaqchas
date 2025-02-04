<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\User;

class PdfController extends Controller
{
    public function generateInvoice()
    {
        $users = User::where('rol_id', 3)->get();
        $pdf = Pdf::loadView('pdf.user', compact('users'));

        return $pdf->download('factura_'.'.pdf');
    }
}
