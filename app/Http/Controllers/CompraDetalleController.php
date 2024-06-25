<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Aroma;

class CompraDetalleController extends Controller
{
    public function getCompraData(){
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $marcas = Marca::all();
        $aromas = Aroma::all();
        return view('ingresos.index',[
            'productos' => $productos,
            'proveedores' => $proveedores,
            'marcas' => $marcas,
            'aromas' => $aromas,
        ]);
    }
}
