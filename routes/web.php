<?php

use App\Http\Controllers\MovimientosCajaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AromaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CondicionVentaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\CompraDetalleController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovimientoController;
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
Route::resource('clientes', ClienteController::class);
Route::resource('aromas', AromaController::class);
Route::resource('marcas', MarcaController::class);
Route::resource('proveedores', ProveedorController::class)->parameters(['proveedores' => 'proveedor']); //////?????????ruta bug que requiere ser redeclarada por las convenciones.
Route::resource('metodo_pagos', MetodoPagoController::class)->parameters(['metodo_pagos' =>'metodo_pago']);
Route::resource('condiciones-de-ventas', CondicionVentaController::class);
Route::resource('caja', CajaController::class);

Route::post('storeCompraData', [CompraDetalleController::class, 'store'])->name('storeCompraData');


Route::get('login', [LoginController::class, 'vista']);
Route::get('ingreso',[CompraDetalleController::class,'getCompraData'])->name('ingreso');
Route::post('autenticacion', [LoginController::class, 'autenticacion'])->name('login.autenticacion');
Route::get('movimientos', [MovimientosCajaController::class, 'index'])->name('movimientos');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


