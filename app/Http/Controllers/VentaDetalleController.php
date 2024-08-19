<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\Caja;
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
  public function getCompraData($search)
  {
    $search = strval($search).'%';
    $recomendaciones = CompraDetalle::where('producto_id','like', $search)->get();
    $data = StockController::changeThisIdToName($recomendaciones);
    return  $data;
  }

  public static function organizeVentas(Request $request)
  {
    $ventas = $request->all();
    $reorderedArray = [];
    for ($j = 0; $j < count($ventas['cantidad']); $j++) {
      if ($ventas['cantidad'][$j] != 0) {
        $reorderedArray[] = [
          'compra_detalle_id' => $ventas['compra-select'][$j],
          'proveedor_id' => $ventas['proveedor'][$j],
          'marca_id' => $ventas['marca'][$j],
          'producto_id' => $ventas['producto'][$j],
          'aroma_id' => $ventas['aroma'][$j],
          'cantidad' => $ventas['cantidad'][$j],
          'precio_venta' => $ventas['precio'][$j],
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
    $cajaAbierta = Caja::where('estado', 'Abierta')->first();
    $caja = $cajaAbierta->id;
    $array = [
      'usuario_id' => $user_id,
      'caja_id' => $caja,
      'total' => $total,
    ];
    VentaController::store($array);
    $venta_id = Venta::all()->last()->id;

    // ------------------------------------------- //
    $request = new Request([
      'caja_id' => $cajaAbierta->id,
      'tipo_movimiento' => 'E',
      'monto' => $total,
      'descripcion' => 'Venta de productos',
    ]);
    MovimientosCajaController::store($request);
    // ------------------------------------------- //

    foreach ($reorderedArray as $value) {
      $value['venta_id'] = $venta_id;
      $value = VentaDetalle::create($value);
    }

    return redirect()->route('vender')->withSuccess('Venta registrada');
  }

}
