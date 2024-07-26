<?php

namespace App\Http\Controllers;

use App\Models\Aroma;
use App\Models\CompraDetalle;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class VentaDetalleController extends Controller
{
  public function index(){
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
}
