<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCondicionVentaRequest;
use App\Http\Requests\UpdateCondicionVentaRequest;
use App\Models\CondicionVenta;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class CondicionVentaController extends Controller
{
  public function index(): View
  {
    return view('condiciones-de-ventas.index', [
      'condiciones' => CondicionVenta::latest()->paginate(3)
    ]);
  }
  public function create(): View
  {
    return view('condiciones-de-ventas.create');
  }
  public function store(StoreCondicionVentaRequest $request): RedirectResponse
  {
    CondicionVenta::create($request->all());
    return redirect()->route('condiciones-de-ventas.index')
      ->withSuccess('Has añadido una nueva CondicionVenta correctamente.');
  }

  /**
   * Display the specified resource.
   */
  public function show(CondicionVenta $condiciones_de_venta): View
  {
    return view('condiciones-de-ventas.show', [
      'condiciones_de_venta' => $condiciones_de_venta
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(CondicionVenta $condiciones_de_venta): View
  {
    return view('condiciones-de-ventas.edit', [
      'condiciones_de_venta' => $condiciones_de_venta
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCondicionVentaRequest $request, CondicionVenta $condiciones_de_venta): RedirectResponse
  {
    $condiciones_de_venta->update($request->all());
    return redirect()->back()
      ->withSuccess('Has modificado una Condicion de Venta correctamente.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(CondicionVenta $condiciones_de_venta): RedirectResponse
  {
    $condiciones_de_venta->delete();
    return redirect()->route('condiciones-de-ventas.index')
      ->with('warning', 'Has eliminado la Condicion de Venta.');
  }
}
