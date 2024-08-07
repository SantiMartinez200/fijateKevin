<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\Failed\DatabaseUuidFailedJobProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
  public static function getDetalleCompras()
  {
    $compraDetalles = DB::table('compra_detalles')->get();
    return $compraDetalles;

  }

  public static function getDetalleVentas()
  {
    $ventaDetalles = DB::table('venta_detalles')->get();
    return $ventaDetalles;
  }

  public static function calculateStock()
  {
    $compraDetalles = self::getDetalleCompras();
    $ventaDetalles = self::getDetalleVentas();
    for ($i = 0; $i < count($ventaDetalles); $i++) {
      for ($j = 0; $j < count($compraDetalles); $j++) {
        if ($ventaDetalles[$i]->compra_detalle_id == $compraDetalles[$j]->id) {
          $compraDetalles[$j]->cantidad -= $ventaDetalles[$i]->cantidad;
          $compraDetalles[$j]->updated_at = Carbon::now();
        }
      }
    }
    
    return $compraDetalles;
  }

  public static function changeIdToName()
  {
    $compraDetalles = self::calculateStock();
    $marcas = Marca::all();
    $proveedores = Proveedor::all();
    $productos = Producto::all();
    $aromas = Aroma::all();
    for ($i = 0; $i < count($compraDetalles); $i++) {
      foreach ($marcas as $marca)
        if ($marca->id == $compraDetalles[$i]->marca_id) {
          $compraDetalles[$i]->marca_id = $marca->nombre;
        }
      foreach ($proveedores as $proveedor) {
        if ($proveedor->id == $compraDetalles[$i]->proveedor_id) {
          $compraDetalles[$i]->proveedor_id = $proveedor->nombre;
        }
      }
      foreach ($productos as $producto) {
        if ($producto->id == $compraDetalles[$i]->producto_id) {
          $compraDetalles[$i]->producto_id = $producto->nombre;
        }
      }
      foreach ($aromas as $aroma) {
        if ($aroma->id == $compraDetalles[$i]->aroma_id) {
          $compraDetalles[$i]->aroma_id = $aroma->nombre;
        }
      }
    }
    return $compraDetalles;
  }
  public function index(): View
  {
    return view('stock.index', [
      'compraDetalles' => self::changeIdToName(),
    ]);
  }
}