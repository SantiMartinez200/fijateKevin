<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
  public static function generatePDF(){
    $pdf = Pdf::loadView('pdf.registroscaja');
    return $pdf->download('registros_caja.pdf');
  }

}
