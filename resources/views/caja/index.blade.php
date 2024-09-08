@extends('layouts.app')
@section('content')

@if ($message = Session::get('error'))
  <div class="alert alert-danger" role="alert">
    {{ $message }}
  </div>
@endif
{{-- @dd($paginacion); --}}
<div class="container mt-4">
  <div class="card">
    <div class="card-header">
      <h2>Cajas</h2>
    </div>
    <div class="float-left ml-3 mt-2">
      <button type="button" class="btn btn-success btn-sm my-2 btnAbrirCaja" data-toggle="modal"
        data-target="#modalAbrirCaja">
        <i class="bi bi-plus-circle"></i> Abrir Caja
      </button>
    </div>
    <!-- Modal Abrir Caja-->
    <div class="modal fade" id="modalAbrirCaja" tabindex="-1" role="dialog" aria-labelledby="modalAbrirCajaLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAbrirCajaLabel">Abrir Caja</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('caja.store') }}" method="POST">
              @csrf
              <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

              <div class="form-group">
                <label for="fecha">Fecha:</label>
                <input type="date" class="form-control" id="created_at" name="created_at" required>
              </div>
              <div class="form-group">
                <label for="estado">Tipo de Movimiento:</label>
                <select class="form-control" id="estado" name="estado" required>
                  <option value="abierta">Apertura</option>
                </select>
              </div>
              <div class="form-group">
                <label for="monto">Monto inicial:</label>
                <input type="number" class="form-control" id="monto_inicial" name="monto_inicial" step="0.01" required>
              </div>
              <div class="form-group">
                <label for="comentario">Comentario:</label>
                <textarea class="form-control" id="comentario" name="comentario"></textarea>
              </div>
              <button type="submit" id="modalCajaButton" class="btn btn-primary">Aplicar y Abrir</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Generar Movimiento de Caja-->
    <div class="modal fade" id="modalRegistrarMovimiento" tabindex="-1" role="dialog"
      aria-labelledby="modalRegistrarMovimientoLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalRegistrarMovimientoLabel">Generar Movimiento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('storeMovimiento') }}" method="POST">
              @csrf
              <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
              <div class="form-group">
                <label for="fecha">Caja ID:</label>
                <input type="number" class="form-control" id="caja_id" name="caja_id" required>
              </div>
              <div class="form-group">
                <label for="estado">Tipo de Movimiento:</label>
                <select class="form-control" id="tipo_movmiento" name="tipo_movimiento" required>
                  <option value="E">Entrada</option>
                  <option value="S">Salida</option>
                </select>
              </div>
              <div class="form-group">
                <label for="monto">Monto Movimiento:</label>
                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
              </div>
              <div class="form-group">
                <label for="comentario">Descripcion:</label>
                <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Aplicar Movimiento</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <table class="table table-bordered mt-4" id="cajaTable">
        <thead>
          <tr>
            <th>Estado</th>
            <th>Fecha abierta</th>
            <th>Abierta por:</th>
            <th>Fecha Cierre</th>
            <th>Monto Inicial</th>
            <th>Monto Final</th>
            <th>Comentario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($itemsPaginados as $caja)
        <tr>
        <td>{{$caja->estado }}</td>
        <td>{{$caja->created_at }}</td>
        <td>{{$caja->usuario_id}}</td>
        <td>{{$caja->fecha_cierre}}</td>
        <td>{{$caja->monto_inicial }}</td>
        <td>{{$caja->monto_final }}</td>
        <td>{{$caja->comentario }}</td>
        <td>
          <div class="btn-group " role="group" aria-label="Basic example"> <!-- basic example???? -->
          <button id="movimiento" type="button" class="btn btn-success btn-movimiento{{$caja->id}}"
            data-id="{{$caja->id}}" data-toggle="modal" data-target="#modalRegistrarMovimiento">
            Movimiento
          </button>
          <a href="{{ route('caja.close', $caja->id) }}"><button class="btn btn-warning btn-close{{$caja->id}}"
            id="close">Cerrar</button></a>
          </div>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
    {{$itemsPaginados->links()}}
  </div>
</div>
<script>

  let botonModal = document.querySelectorAll('[data-target="#modalRegistrarMovimiento"]');
  let usuario_abrio_caja = '<?php echo Auth::user()->abrio_caja; ?>';
  let btnAbrirCaja = document.querySelector(".btnAbrirCaja");
  
  if (usuario_abrio_caja == 1) {
    btnAbrirCaja.disabled = true;
  } else {
    btnAbrirCaja.disabled = false;
  }

  const cajas = @json($itemsPaginados);
  aux = cajas['data'];
  var flag = false;
  var auth_user = '<?php echo(Auth::user()->id) ?>'
  for (const key in aux) {
    if (aux.hasOwnProperty(key)) {
      //console.log(aux);
      if (aux[key]['estado'] == 'cerrada' || aux[key]['usuario_id'] != auth_user) {
        let btnMovimiento = document.querySelector(`.btn-movimiento${aux[key]['id']}`);
        let btnCerrar = document.querySelector(`.btn-close${aux[key]['id']}`);
        btnMovimiento.disabled = true;
        btnCerrar.disabled = true;
        flag = true;
      }
    }
  }
  //--------------------------------------------------//

  const barra = document.querySelector('#sidebarCollapse')
  const barra2 = document.querySelector('#sidebar')

  window.onscroll = function () {
    //console.log(barra2.classList[0], 'fuera');
    let y = window.scrollY
    if (y > 350 && barra2.classList[0] == undefined) {
      //barra2.classList.remove('active')
      //console.log(barra2.classList[0], 'adentro');
      barra2.classList.add('active');

    }
    //console.log(window.scrollY);
  }
  //Esto debería ir en una function para abrir el modal con onclick().
  //Ej: Function abrirModalMovimiento();
  botonModal.forEach(btn => {
    btn.addEventListener('click', function () {
      // Obtener columnas desde TR padre:
      let tds = this.closest('tr').querySelectorAll('td');
      // Obtener ID desde el botón
      let id = this.dataset.id;
      // Asignar datos a ventana modal:
      document.querySelector('#caja_id').value = id;
      //document.querySelector('#estudiante').value = nombre;
      //document.querySelector('#cedula').value = cedula;
      console.log();
      
      //console.log('abrir modal');
      $('#modalRegistrarMovimiento').modal();
    });
  });
  //--------------------------------------------------//
</script>
@endsection