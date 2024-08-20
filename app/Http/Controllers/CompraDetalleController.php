<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Aroma;
use Illuminate\Support\Facades\Auth;

class CompraDetalleController extends Controller
{
  public function getData()
  {
    if (CajaController::cajaIsOpen() == true){

      $productos = Producto::all();
      $proveedores = Proveedor::all();
      $marcas = Marca::all();
      $aromas = Aroma::all();
      return view('ingresos.index', [
        'productos' => $productos,
        'aromas' => $aromas,
        'proveedores' => $proveedores,
        'marcas' => $marcas,
      ]);
    }else{
      return redirect()->route('caja.index')->with('error', 'Debes abrir una caja antes');
    }
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $user = Auth::user()->id;
    $cajaAbierta = Caja::where('estado', 'Abierta')->first()->get();
    
    $total = $data['precio_costo'] * $data['cantidad'];
    $array = ['usuario_id' => $user, 'caja_id' => $cajaAbierta[0]["id"], 'total' => $total];
    CompraController::store($array);
    $idCompra = CompraController::getId();
    // ------------------------------------------- //
    $producto = Producto::find($data['producto_id']);
    $request = new Request([
      'caja_id' => $cajaAbierta[0]["id"],
      'tipo_movimiento' => 'S',
      'monto' => $total,
      'descripcion' => 'Compra del producto: ' . $producto->nombre . ' por $' . $data["precio_costo"] . ' X ' . $data["cantidad"]. ' U',
    ]);
    MovimientosCajaController::store($request);
    // ------------------------------------------- //

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
