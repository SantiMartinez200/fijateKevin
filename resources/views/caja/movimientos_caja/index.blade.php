@extends('layouts.app')
@section('content')

<div class="container">
  <table class="table table-bordered mt-4">
    <thead >
      <tr>
        <th>ID de caja</th>
        <th>Estado</th>
        <th>Fecha abierta</th>
        <th>Fecha Cierre</th>
        <th>Movimientos</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($cajas as $caja)
      <tr>
      <td>{{$caja->id}}</td>
      <td>{{$caja->estado}}</td>
      <td>{{$caja->created_at}}</td>
      <td>{{$caja->fecha_cierre}}</td>
      <td><button type="button" class="btn btn-primary"><a href="{{route('movimientos-caja',$caja->id)}}">Ver Movimientos
        </a></button></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
@endsection