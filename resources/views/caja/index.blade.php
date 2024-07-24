@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="card">
    <div class="card-header">
      <h2>Cajas</h2>
    </div>
    <div class="float-left ml-3 mt-2">
      <button type="button" class="btn btn-success btn-sm my-2 " data-toggle="modal" data-target="#modalAbrirCaja">
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
                <label for="tipo">Metodo de pago:</label>
                <select class="form-control" id="metodo_pago_id" name="metodo_pago_id" required>
                  @foreach ($metodos as $metodo)
            <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
          @endforeach
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
                <label for="tipo">Metodo de pago:</label>
                <select class="form-control" id="metodo_pago_id" name="metodo_pago_id" required>
                  @foreach ($metodos as $metodo)
            <option value="{{$metodo->id}}">{{$metodo->nombre}}</option>
          @endforeach
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
              <button type="submit" class="btn btn-primary">Aplicar y Abrir</button>
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
            <th>Metodo de Pago</th>
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
          @foreach ($cajas as $caja)
        <tr id="registry">
        <td>{{$caja->estado }}</td>
        <td>{{$caja->metodo_pago_id}}</td>
        <td>{{$caja->created_at }}</td>
        <td>{{$caja->usuario_id}}</td>
        <td>{{$caja->fecha_cierre}}</td>
        <td>{{$caja->monto_inicial }}</td>
        <td>{{$caja->monto_final }}</td>
        <td>{{$caja->comentario }}</td>
        <td>
          <div class="btn-group" role="group" aria-label="Basic example"> <!-- basic example???? -->
          <button id="movimiento" type="button" class="btn btn-success" data-id="{{$caja->id}}"
            data-toggle="modal" data-target="#modalRegistrarMovimiento">
            Movimiento
          </button>
          <a href="{{ route('caja.edit', $caja->id) }}"><button id="edit"
            class="btn btn-primary">Editar</button></a>
          <a href="{{ route('caja.destroy', $caja->id) }}" class="btn btn-danger">Eliminar</a>
          <a href="{{ route('caja.close', $caja->id) }}" class="btn btn-warning" id="close">Cerrar</a>
          </div>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>
  let botonModal = document.querySelectorAll('[data-target="#modalRegistrarMovimiento"]');
  let botonMovimiento = document.getElementById('movimiento');
  let botonEdit = document.getElementById('edit');
  const table = document.getElementById('cajaTable');
  const rows = table.querySelectorAll('tbody tr');
  rows.forEach((row) => {
    const cells = row.querySelectorAll('td');
    const rowData = Array.from(cells).map(cell => cell.textContent.trim());
    console.log(rowData[0]);
    if (rowData[0] === 'cerrada') {
      botonEdit.disabled = true;
      botonMovimiento.disabled = true;
    }
  });
  botonModal.forEach(btn => {
    btn.addEventListener('click', function () {
      // Obtener columnas desde TR padre:
      let tds = this.closest('tr').querySelectorAll('td');
      // Obtener ID desde el botón
      let id = this.dataset.id;
      // Obtener datos por contenido de TD:
      //let nombre = tds[0].innerText;
      //let cedula = tds[1].innerText;
      //let fecha = tds[6].innerText;
      // Asignar datos a ventana modal:
      document.querySelector('#caja_id').value = id;
      //document.querySelector('#estudiante').value = nombre;
      document.querySelector('#cedula').value = cedula;
      console.log('abrir modal');
      $('#modalRegistrarMovimiento').modal();
    });
  });

</script>
@endsection