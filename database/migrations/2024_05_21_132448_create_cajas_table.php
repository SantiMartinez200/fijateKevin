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
      $table->string('estado');
      $table->integer('usuario_id');
      $table->integer('metodo_pago_id')->nullable();
      $table->double('monto_inicial');
      $table->double('comentario')->nullable();
      $table->double('monto_final')->nullable();
      $table->timestamps();
      $table->dateTime('fecha_cierre')->nullable();
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
