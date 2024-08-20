@extends('layouts.app')
@section('content')

<!-- Modal Structure -->
<div class="modal fade" id="modalRegistrarMovimiento" tabindex="-1" role="dialog"
    aria-labelledby="modalRegistrarMovimientoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarMovimientoLabel">Formulario de Ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <form action="{{ route('storeCompraData') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="marca">Marca</label>
                          <select name="marca_id" id="marca" class="form-control">
                              <option value="N/E" selected>Seleccione</option>
                              @foreach ($marcas as $marca)
                                  <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                              @endforeach
                          </select>
                      </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="proveedor">Proveedor</label>
                          <select name="proveedor_id" id="proveedor" class="form-control">
                              <option value="N/E" selected>Seleccione</option>
                              @foreach ($proveedores as $proveedor)
                                  <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                              @endforeach
                          </select>
                      </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="producto">Producto</label>
                          <select name="producto_id" id="producto_id" class="form-control">
                              <option value="N/E" selected>Seleccione</option>
                              @foreach ($productos as $producto)
                                  <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                              @endforeach
                          </select>
                      </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="aroma">Aroma</label>
                          <select name="aroma_id" id="aroma" class="form-control">
                              <option value="N/E" selected>Seleccione</option>
                              @foreach ($aromas as $aroma)
                                  <option value="{{ $aroma->id }}">{{ $aroma->nombre }}</option>
                              @endforeach
                          </select>
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="precio_costo">Costo</label>
                          <input type="text" name="precio_costo" id="precio_costo" class="form-control">
                      </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="cantidad">Cantidad a Ingresar</label>
                          <input type="number" name="cantidad" id="cantidad" class="form-control">
                      </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="porcentaje_ganancia">Porcentaje de ganancia</label>
                          <input type="number" name="porcentaje_ganancia" id="porcentaje_ganancia" class="form-control">
                      </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="precio_venta">Precio de venta</label>
                          <input type="text" name="precio_venta" id="precio_venta" class="form-control">
                      </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    @if ($message = Session::get('message'))
      <div class="alert alert-success" role="alert">
      {{ $message }}
      </div>
    @endif
  <button id="movimiento" type="button" class="btn btn-success btn-movimiento" data-toggle="modal" data-target="#modalRegistrarMovimiento">
    Realizar un Ingreso
</button>
</div>




@endsection
<script>
   let botonModal = document.querySelectorAll('[data-target="#modalRegistrarMovimiento"]');
botonModal.forEach(btn => {
    btn.addEventListener('click', function () {
      // Obtener columnas desde TR padre:
      let tds = this.closest('tr').querySelectorAll('td');
      // Obtener ID desde el botón
      let id = this.dataset.id;
      // Asignar datos a ventana modal:
      document.querySelector('#caja_id').value = id;
      //document.querySelector('#estudiante').value = nombre;
      document.querySelector('#cedula').value = cedula;
      console.log('abrir modal');
      $('#modalGenerarMovimiento').modal();
    });
  });
</script>
<script src="{{asset('js/compras.js')}}"></script>
