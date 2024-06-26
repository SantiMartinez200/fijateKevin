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
    Schema::create('tiendas', function (Blueprint $table) {
      $table->id();
      $table->string('nombre');
      $table->string('telefono');
      $table->string('email');
      $table->string('direccion_calle');
      $table->integer('direccion_numero');
      $table->string('localidad');
      $table->string('departamento');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tiendas');
  }
};
