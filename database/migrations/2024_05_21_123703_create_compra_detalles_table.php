<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('compra_detalles', function (Blueprint $table) {
      $table->id();
      $table->integer('compra_id');
      $table->integer('producto_id');
      $table->integer('proveedor_id');
      $table->integer('aroma_id');
      $table->double('precio_costo');
      $table->integer('cantidad');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('compra_detalles');
  }
};
