<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Aroma;
use \App\Models\Cliente;
use \App\Models\Marca;
use \App\Models\Producto;
use \App\Models\MetodoPago;
use \App\Models\Proveedor;
use \App\Models\Tienda;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();
        \App\Models\Aroma::factory(10)->create();
        \App\Models\Cliente::factory(5)->create();
        \App\Models\Marca::factory(7)->create();
        \App\Models\Producto::factory(20)->create();
        \App\Models\MetodoPago::factory(2)->create();
        \App\Models\Proveedor::factory(4)->create();
        \App\Models\Tienda::factory(1)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
