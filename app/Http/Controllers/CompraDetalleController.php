<?php

namespace App\Http\Controllers;

use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Aroma;

class CompraDetalleController extends Controller
{
  public function getData()
  {
    $productos = Producto::all();
    $proveedores = Proveedor::all();
    $marcas = Marca::all();
    $aromas = Aroma::all();
    return view('ingresos.index', [
      'productos' => $productos,
      'proveedores' => $proveedores,
      'marcas' => $marcas,
      'aromas' => $aromas,
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $user = 1;
    $caja = 1;
    $total = $data['precio_costo'] * $data['cantidad'];
    $array = ['usuario_id' => $user, 'caja_id' => $caja, 'total' => $total];
    CompraController::store($array);
    $idCompra = CompraController::getId();
    try {
      CompraDetalle::create([
        'compra_id' => $idCompra,
        'marca_id' => $data['marca_id'],
        'proveedor_id' => $data['proveedor_id'],
        'producto_id' => $data['producto_id'],
        'aroma_id' => $data['aroma_id'],
        'precio_costo' => $data['precio_costo'],
        'porcentaje_ganancia' => $data['porcentaje_ganancia'],
        'precio_venta' => $data['precio_venta'],
        'cantidad' => $data['cantidad'],
      ]);
      return redirect()->route('ingreso')->with('message', 'Ingreso realizado con éxito');
    } catch (\Throwable $e) {
      $err = $e->getMessage();
      return view('ingresos.index', ['err' => $err]);
    }
  }
}
