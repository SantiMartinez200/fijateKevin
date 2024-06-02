<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CondicionVenta extends Model
{
    use HasFactory;
    public function condicionProducto():HasMany{
    return $this->hasMany(Producto::class);
    }
}
