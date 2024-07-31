@extends('layouts.app')
@section('content')
<div class="container">
  <div class="card">
    <div class="card-header">
      <h3>Stock</h3>
    </div>
    <div class="card-body">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Código Detalle</th>
            <th>Marca</th>
            <th>Proveedor</th>
            <th>Producto</th>
            <th>Aroma</th>
            <th>Precio</th>
            <th>Cantidad STOCK</th>
            <th>Ult. Actualiz.</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($compraDetalles as $compraDetalle)
        <tr>
        <td>{{$compraDetalle->id}}</td>
        <td>{{$compraDetalle->marca_id}}</td>
        <td>{{$compraDetalle->proveedor_id}}</td>
        <td>{{$compraDetalle->producto_id}}</td>
        <td>{{$compraDetalle->aroma_id}}</td>
        <td>{{$compraDetalle->precio_costo}}</td>
        <td>{{$compraDetalle->cantidad}}</td>
        <td>{{$compraDetalle->updated_at}}</td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection