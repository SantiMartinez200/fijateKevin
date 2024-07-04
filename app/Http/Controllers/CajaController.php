<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Caja;

class CajaController extends Controller
{
    public function index(): View
    {
        $movimientos = Caja::all();
        return view('caja.index', compact('movimientos'));
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


