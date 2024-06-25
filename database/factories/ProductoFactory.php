<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
            'nombre' =>fake()->name(),
            'aroma_id' =>fake()->randomNumber(1,true),
            'condicion_venta_id' =>fake()->randomNumber(1,true),
            'descripcion'=>fake()->paragraph(),
        ];
    }
}
