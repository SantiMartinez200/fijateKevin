<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Caja;
use App\Models\MetodoPago;
use App\Models\User;

class CajaController extends Controller
{
    public function index(): View
    {
        $cajas = Caja::all();
        $metodos = MetodoPago::all();
        $users = User::all();
        foreach ($cajas as $caja) {
            if ($caja->metodo_pago_id == $metodos->first()->id) {
                $caja->metodo_pago_id = $metodos->first()->nombre;
            } else {
                $caja->metodo_pago_id = $metodos->find($caja->metodo_pago_id)->nombre;
            }
            if($caja->usuario_id == $users->first()->id){
                $caja->usuario_id = $users->first()->name;
            }else{
                $caja->usuario_id = $users->find($caja->usuario_id)->name;
            }
            if ($caja->monto_final == 0) {
                $caja->monto_final = 'N/D';
            }
            if($caja->fecha_cierre == null){
                $caja->fecha_cierre = 'N/D';
            }
        }
        return view('caja.index', compact('cajas','metodos'));
    }

    public function create(): View
    {
        return view('caja.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $caja = $request->all();
        Caja::create($caja);

        
        return redirect('caja');
    }

    public function show(): View
    {
    }


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


