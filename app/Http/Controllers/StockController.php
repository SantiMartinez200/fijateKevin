<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\CompraDetalle;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\VentaDetalle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StockController extends Controller
{
  public function index(): View
  {
    return view('stock.index', [
      'compraDetalles' => self::changeIdToName(),
    ]);
  }

  public static function getThisDetalleCompras($id)
  {
    $compraDetalles = CompraDetalle::where('id', $id)->get();
    return $compraDetalles;
  }

  public static function getThisDetalleVentas($id)
  {
    $ventaDetalles = VentaDetalle::where('compra_detalle_id', $id)->get();
    return $ventaDetalles;
  }

  public static function calculateThisStock($id)
  {
    $compraDetalles = self::getThisDetalleCompras($id);
    $ventaDetalles = self::getThisDetalleVentas($id);
    for ($i = 0; $i < count($ventaDetalles); $i++) {
      for ($j = 0; $j < count($compraDetalles); $j++) {
        if ($ventaDetalles[$i]->compra_detalle_id == $compraDetalles[$j]->id) {
          $compraDetalles[$j]->cantidad -= $ventaDetalles[$i]->cantidad;
        }
      }
    }
    return $compraDetalles[0]->cantidad;
  }


  public static function changeThisIdToName($recomendaciones)
  {
    //dd($recomendaciones);
    foreach ($recomendaciones as $recomendacion) {
      $proveedor = Proveedor::find($recomendacion->proveedor_id);
      $marca = Marca::find($recomendacion->marca_id);
      $producto = Producto::find($recomendacion->producto_id);
      $aroma = Aroma::find($recomendacion->aroma_id);
      $recomendacion->proveedor_id = $proveedor->nombre;
      $recomendacion->marca_id = $marca->nombre;
      $recomendacion->producto_id = $producto->nombre;
      if($recomendacion->aroma_id == "N/E"){
        $recomendacion->aroma_id = "N/E";
      }else{
        $recomendacion->aroma_id = $aroma->nombre;
      }
      
    }
    return $recomendaciones;
  }


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



  public function changeIdToName()
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
}