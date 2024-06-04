<?php

use App\Http\Controllers\AromaController;
use App\Http\Controllers\CondicionVentaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::Post('create-user', UserController::Class); //Ruta externa a middleware auth

Route::get('/', function () {
    return view('welcome');
});

//Ingresar estas rutas al middleware auth
Route::resource('productos', ProductoController::class);
Route::resource('aromas', AromaController::class);
Route::resource('marcas', MarcaController::class);
Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']); //////?????????ruta bug que requiere ser redeclarada por las convenciones.
Route::resource('metodo_pagos', MetodoPagoController::class)->parameters(['metodo_pagos' =>'metodo_pago']);
Route::resource('condiciones-de-ventas', CondicionVentaController::class);
