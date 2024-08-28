<?php

namespace App\Http\Controllers;

use App\Mail\MailerController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Caja;
use App\Models\MetodoPago;
use App\Models\User;

class CajaController extends Controller
{
   public static function cajaIsOpen()
  {
    $caja_abierta = Caja::where('estado', 'Abierta')->where('usuario_id', Auth::user()->id)->first();
    if ($caja_abierta) {
      return true;
    } else {
      return false;
    }
  }
  public function index(): View
  {
    $cajaAbierta = Caja::where("estado", "abierta")->get();
    $cajas = Caja::all();
    $metodos = MetodoPago::all();
    $users = User::all();
    foreach ($cajas as $caja) {
      if ($caja->usuario_id == $users->first()->id) {
        $caja->usuario_id = $users->first()->name;
      } else {
        $caja->usuario_id = $users->find($caja->usuario_id)->name;
      }
      if ($caja->monto_final == 0) {
        $caja->monto_final = 'N/D';
      }
      if ($caja->fecha_cierre == null) {
        $caja->fecha_cierre = 'N/D';
      }
    }
    return view('caja.index', compact('cajas', 'metodos', 'cajaAbierta'));
  }

  public function create(): View
  {
    return view('caja.create');
  }
  public function store(Request $request): RedirectResponse
  {
    $caja = $request->all();
    Caja::create($caja);
    Mail::to('tribalessence@gmail.com')->send(new MailerController);
    return redirect('caja');
  }

  public function close(Request $request): RedirectResponse
  {
    $caja = Caja::findOrFail($request->id);
    $montoFinal = MovimientosCajaController::getMonto($request->id);
    $caja->monto_final = $montoFinal['monto_final'];
    $caja->fecha_cierre = Carbon::now()->format('Y-m-d H:i:s');
    $caja->estado = 'cerrada';
    $caja->save();
    return redirect(route('caja.index'));
  }

  // public function show(): View
  // {
  // }

  public function edit(): View
  {

  }


  public function update(): RedirectResponse
  {

  }


  public function destroy(): RedirectResponse
  {

  }
}


