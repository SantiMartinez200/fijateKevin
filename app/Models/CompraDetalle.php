<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompraDetalle extends Model
{
  use HasFactory;
  protected $fillable = ["compra_id", "producto_id", "proveedor_id", "cantidad", "precio_costo", "aroma_id", "caja_id", "marca_id"];
  protected $table = 'compra_detalles';
  public function compra(): BelongsTo //
  {
    return $this->belongsTo(Compra::class);
  }

  public function caja(): BelongsTo
  {
    return $this->belongsTo(Caja::class);
  }
  public function productoCompraDetalle(): BelongsTo //
  {
    return $this->belongsTo(Producto::class);
  }

  public function proveedorCompraDetalle(): BelongsTo //
  {
    return $this->belongsTo(Proveedor::class);
  }

  public function aromaCompraDetalle(): BelongsTo //
  {
    return $this->belongsTo(Aroma::class);
  }
}
