<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\CompraDetalle;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VentaDetalleController extends Controller
{
  public function index()
  {
    $compras = CompraDetalle::all();
    return view('ventas.index', compact('compras'));
  }
  public function getCompraData($id)
  {
    $compra = CompraDetalle::find($id);
    $marcas = Marca::all();
    $proveedores = Proveedor::all();
    $productos = Producto::all();
    $aromas = Aroma::all();
    foreach ($marcas as $marca) {
      if ($marca->id == $compra->marca_id) {
        $compra->marca_id = $marca->nombre;
      }
    }
    foreach ($proveedores as $proveedor) {
      if ($proveedor->id == $compra->proveedor_id) {
        $compra->proveedor_id = $proveedor->nombre;
      }
    }
    foreach ($productos as $producto) {
      if ($producto->id == $compra->producto_id) {
        $compra->producto_id = $producto->nombre;
      }
    }
    foreach ($aromas as $aroma) {
      if ($aroma->id == $compra->aroma_id) {
        $compra->aroma_id = $aroma->nombre;
      }
    }
    return response()->json(['compra' => $compra]);
  }

  public static function organizeVentas(Request $request)
  {
    $ventas = $request->all();
    $reorderedArray = [];
    //dd($ventas);
    for ($j = 0; $j < count($ventas['cantidad']); $j++) {
      if ($ventas['cantidad'][$j] != 0) {
        $reorderedArray[] = [
          'compra_detalle_id' => $ventas['compra-select'][$j],
          'proveedor_id' => $ventas['proveedor'][$j],
          'marca_id' => $ventas['marca'][$j],
          'producto_id' => $ventas['producto'][$j],
          'aroma_id' => $ventas['aroma'][$j],
          'cantidad' => $ventas['cantidad'][$j],
          'precio_costo' => $ventas['precio'][$j],
        ];
      }
    }
    //dd($reorderedArray);
    return $reorderedArray;
  }

  public static function changeNameToId(Request $request)
  {
    $reorderedArray = self::organizeVentas($request);
    $marcas = Marca::all();
    $proveedores = Proveedor::all();
    $productos = Producto::all();
    $aromas = Aroma::all();
    for ($i = 0; $i < count($reorderedArray); $i++) {
      foreach ($marcas as $marca)
        if ($marca->nombre == $reorderedArray[$i]['marca_id']) {
          $reorderedArray[$i]['marca_id'] = $marca->id;
        }
      foreach ($proveedores as $proveedor) {
        if ($proveedor->nombre == $reorderedArray[$i]['proveedor_id']) {
          $reorderedArray[$i]['proveedor_id'] = $proveedor->id;
        }
      }
      foreach ($productos as $producto) {
        if ($producto->nombre == $reorderedArray[$i]['producto_id']) {
          $reorderedArray[$i]['producto_id'] = $producto->id;
        }
      }
      foreach ($aromas as $aroma) {
        if ($aroma->nombre == $reorderedArray[$i]['aroma_id']) {
          $reorderedArray[$i]['aroma_id'] = $aroma->id;
        }
      }
    }
    return $reorderedArray;
  }

  public function store(Request $request)
  {
    $reorderedArray = self::changeNameToId($request);

    $total = VentaController::calculateTotal($reorderedArray);
    $user_id = auth()->user()->id;
    $caja = 1;
    $array = [
      'usuario_id' => $user_id,
      'caja_id' => $caja,
      'total' => $total,
    ];
    VentaController::store($array);
    $venta_id = Venta::all()->last()->id;

    foreach ($reorderedArray as $value) {
      $value['venta_id'] = $venta_id;
      $value = VentaDetalle::create($value);
    }

    return redirect()->route('venta')->withSuccess('Venta registrada');
  }

}
