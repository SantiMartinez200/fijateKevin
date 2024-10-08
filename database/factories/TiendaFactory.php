<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tienda>
 */
class TiendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' =>fake()->company(),
            'telefono' =>fake()->randomNumber(6,true),
            'email' =>fake()->email(),
            'direccion_calle' =>fake()->streetName(),
            'direccion_numero' =>fake()->randomNumber(4,true),
            'localidad' =>fake()->city(),
            'departamento' =>fake()->state(),
        ];
    }
}
