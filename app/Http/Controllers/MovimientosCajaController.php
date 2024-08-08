<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\MovimientosCaja;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MovimientosCajaController extends Controller
{
  public function index(): View
  {
    return view('caja.movimientos_caja.index', [
      'cajas' => Caja::latest()->paginate(3)
    ]);
  }

  public function getMovimientos($id)
  {
    $caja = Caja::findOrFail($id);
    $movimientos = $caja->movimientos;
    $movimientosFormateados = $movimientos->map(function ($movimiento) {
      $movimiento->fecha = Carbon::parse($movimiento->created_at)->format('d/m/Y H:i:s');
      return $movimiento;
    });
    $datosAdicionales = ['caja_fecha' => date_format($caja->created_at, 'd/m/Y')];
    return response()->json(['movimientos' => $movimientosFormateados, 'datosAdicionales' => $datosAdicionales]);
  }

  public static function getMonto($id)
  {
    $caja = Caja::find($id);
    $movimientosSum = DB::table('movimientos_caja')->where('caja_id', $id)->sum('monto');
    if ($caja->monto_inicial > 0) {
      $movimientosSum += $caja->monto_inicial;
      return response()->json(['monto_final' => $movimientosSum, 'monto_inicial' => $caja->monto_inicial]);
    } else {
      return response()->json(['monto_final' => $movimientosSum, 'monto_inicial' => $caja->monto_inicial]);
    }
  }
  public static function store(Request $request): RedirectResponse
  {
    $registro = $request->all();
    if ($registro["tipo_movimiento"] == "S") {
      $registro["monto"] = $registro["monto"] * -1;
    }
    MovimientosCaja::create($registro);
    return redirect(route('caja.index'));
  }
}
