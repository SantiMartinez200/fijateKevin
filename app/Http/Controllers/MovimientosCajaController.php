<?php

namespace App\Http\Controllers;

use App\Models\MovimientosCaja;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovimientosCajaController extends Controller
{
  public function index(): View
  {
    return view('caja.movimientos_caja.index', [
      'movimientos' => MovimientosCaja::latest()->paginate(5)
    ]);
  }
}
