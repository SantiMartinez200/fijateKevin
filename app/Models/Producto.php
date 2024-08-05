<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
  protected $fillable = [
    'nombre',
    'aroma_id',
    'condicion_venta_id',
    'precio_costo',
    'descripcion'
  ];

  use HasFactory;
  public function productoCompra(): HasMany
  {
    return $this->hasMany(CompraDetalle::class);
  }
  public function productoVenta(): HasMany
  {
    return $this->hasMany(VentaDetalle::class);
  }
  public function condicion(): BelongsTo
  {
    return $this->belongsTo(CondicionVenta::class);
  }
}
