@extends('layouts.app')
@section('content')
<div class="container">
  @if ($message = Session::get('message'))
    <div class="alert alert-success" role="alert">
      {{ $message }}
    </div>
  @endif
 <div class="card mb-2 d-flex">
    <div class="card-header">Ingreso</div>
        <div class="card-body">
            <form action="{{route('storeCompraData')}}" method="POST" class="form-control">
              @csrf
              @method('POST')
            <div>
            <label for="marca">Marca</label>
            <select name="marca_id" id="marca" class="form-control">
               @foreach ($marcas as $marca)    
                <option value="{{$marca->id}}">{{$marca->nombre}}</option>
               @endforeach 
            </select>
            <label for="proveedor">Proveedor</label>
            <select name="proveedor_id" id="proveedor" class="form-control">
                @foreach ($proveedores as $proveedor)    
                <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
               @endforeach 
            </select>
        </div>
        <div>
            <label for="producto">Producto</label>
            <select name="producto_id" id="producto" class="form-control">
                @foreach ($productos as $producto)    
                <option value="{{$producto->id}}">{{$producto->nombre}}</option>
               @endforeach 
            </select>
        
            <label for="aroma">Aroma</label>
            <select name="aroma_id" id="aroma" class="form-control">
                @foreach ($aromas as $aroma)    
                <option value="{{$aroma->id}}">{{$aroma->nombre}}</option>
               @endforeach 
            </select>
        </div>
        <div>
            <label for="costo">Costo</label>
            <input type="number" name="precio_costo" class="form-control">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" class="form-control">
            <input type="submit" value="Ingresar" class="btn btn-primary form-control mt-2">
        </div>
        </div>        
    </form>
 </div>
 <div class="card">
    <div class="card-header">Stock</div>
        <div class="card-body">
          @if(isset($stocks))
            
          @endif
        </div>      
 </div>
</div>
@endsection