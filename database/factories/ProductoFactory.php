<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'nombre' => fake()->word(),
      'aroma_id' => fake()->randomNumber(4, false),
      'condicion_venta_id' => fake()->randomNumber(1, true),
      'precio_costo' => fake()->randomFloat(2, 0, 3000),
      'descripcion' => fake()->text(10),
    ];
  }
}
