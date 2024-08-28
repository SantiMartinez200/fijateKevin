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
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VentaDetalleController extends Controller
{
  public function index()
  {
    if (CajaController::cajaIsOpen() == true) {
      return view('ventas.index');
    } else {
      return redirect()->route('caja.index')->with('error', 'Debes abrir una caja antes');
    }
  }
  public function findEntrada($search)
  {
    $search = strval($search) . '%';
    $recomendaciones = DB::table('compra_detalles')->where('producto_id', 'like', $search)->join('productos','compra_detalles.producto_id','=','productos.id')->join('proveedores', 'compra_detalles.proveedor_id', '=', 'proveedores.id')->join('aromas', 'compra_detalles.aroma_id', '=', 'aromas.id')->join('marcas', 'compra_detalles.marca_id', '=', 'marcas.id')->select('compra_detalles.id','compra_detalles.compra_id','compra_detalles.created_at','compra_detalles.marca_id','marcas.nombre AS nombre_marca','compra_detalles.producto_id','productos.nombre AS nombre_producto','compra_detalles.proveedor_id','proveedores.nombre AS nombre_proveedor','compra_detalles.aroma_id','aromas.nombre AS nombre_aroma','compra_detalles.precio_costo','compra_detalles.porcentaje_ganancia','compra_detalles.precio_venta','compra_detalles.cantidad')->get();
    return $recomendaciones;
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
    return $reorderedArray;
  }

  // public static function changeNameToId(Request $request)
  // {
  //   $reorderedArray = self::organizeVentas($request);
  //   $marcas = Marca::all();
  //   $proveedores = Proveedor::all();
  //   $productos = Producto::all();
  //   $aromas = Aroma::all();
  //   for ($i = 0; $i < count($reorderedArray); $i++) {
  //     foreach ($marcas as $marca)
  //       if ($marca->nombre == $reorderedArray[$i]['marca_id']) {
  //         $reorderedArray[$i]['marca_id'] = $marca->id;
  //       }
  //     foreach ($proveedores as $proveedor) {
  //       if ($proveedor->nombre == $reorderedArray[$i]['proveedor_id']) {
  //         $reorderedArray[$i]['proveedor_id'] = $proveedor->id;
  //       }
  //     }
  //     foreach ($productos as $producto) {
  //       if ($producto->nombre == $reorderedArray[$i]['producto_id']) {
  //         $reorderedArray[$i]['producto_id'] = $producto->id;
  //       }
  //     }
  //     foreach ($aromas as $aroma) {
  //       if ($aroma->nombre == $reorderedArray[$i]['aroma_id']) {
  //         $reorderedArray[$i]['aroma_id'] = $aroma->id;
  //       }
  //     }
  //   }
  //   return $reorderedArray;
  // }

  public function store(Request $request)
  {
    $reorderedArray = self::organizeVentas($request);
    $total = VentaController::calculateTotal($reorderedArray);
    $user_id = auth()->user()->id;
    $cajaAbierta = Caja::where('estado', 'Abierta')->where('usuario_id',$user_id)->first();
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
