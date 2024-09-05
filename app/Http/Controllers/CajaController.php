<?php

namespace App\Http\Controllers;

use App\Mail\MailerController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Pagination\Paginator;


use App\Models\Caja;
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
  public function index(Request $request): View
  {
    
    
    $cajaAbierta = Caja::where("estado", "abierta")->where("usuario_id", "LIKE", Auth::user()->id)->get();
    $cajas = Caja::all();
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
//------------------------------
    $data = collect($cajas);
    $paginaActual = LengthAwarePaginator::resolveCurrentPage();
    $porPagina = 6;
    $itemActualPagina = $data->slice(($paginaActual - 1)* $porPagina, $porPagina)->all();
    $itemsPaginados =  new LengthAwarePaginator(
      $itemActualPagina,
      $data->count(),
      $porPagina,
      $paginaActual,
      ['path'=> request()->url(),
      'query'=>request()->query(),
      ]
    );
    return view('caja.index', compact('itemsPaginados', 'cajaAbierta','cajas'));
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


  public function searcheable(){
    $caja = Caja::search()->get();
    dd($caja);
  }
}


