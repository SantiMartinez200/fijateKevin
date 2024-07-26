<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(): View
    {
    $ventas = Venta::all();
        return view('ventas.index',compact('ventas'));
    }
}
