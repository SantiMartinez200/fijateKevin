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
    Schema::create('cajas', function (Blueprint $table) {
      $table->id();
      $table->integer('usuario_id');
      $table->double('monto_inicial');
      $table->double('monto_final');
      $table->timestamps();
      $table->dateTime('fecha_cierre');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cajas');
  }
};
