@extends('layouts.app')
@section('content')

<div class="container">
  <table class="table table-bordered mt-4">
    <thead>
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
      <td><button type="button" class="btn btn-primary" data-toggle="modal" data-id="{{$caja->id}}"
        data-target="#modalVerMovimiento">Ver Movimientos
        </button></td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

<div class="modal fade" id="modalVerMovimiento" tabindex="-1" role="dialog" aria-labelledby="modalVerMovimientoLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerMovimientoLabel">Movimientos de Caja</h5>
        <br>
        <h4 class="form-control" id="h4Inicial">Monto Inicial:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="movimientosTable">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Descripción</th>
              <th>Monto</th>
              <th>Tipo de Movimiento</th>
            </tr>
          </thead>
          <tbody>
            <!--Filas agregadas desde Ajax-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <h5 class="form-control" id="h5Monto">Monto total actualizado:</h5>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  let botones = document.querySelectorAll('[data-target="#modalVerMovimiento"]');
  botones.forEach(btn => {
    btn.addEventListener('click', function () {
      let id = this.dataset.id;
      // Realizar una solicitud AJAX para obtener los movimientos
      fetch(`/caja/${id}/movimientos`)
        .then(response => response.json())
        .then(data => {
          // Limpiar las filas de la tabla actual
          const movimientosTableBody = document.getElementById('movimientosTable').querySelector('tbody');
          movimientosTableBody.innerHTML = '';
          let h5 = document.getElementById("modalVerMovimientoLabel");
          h5.textContent = `Movimientos de la Caja del: ${data.datosAdicionales.caja_fecha}`;
          // Agregar cada movimiento como fila + dato
          data.movimientos.forEach(movimiento => {
            const row = document.createElement('tr');

            const datetime = document.createElement('td');
            datetime.textContent = movimiento.fecha;
            row.appendChild(datetime);

            const cellDescripcion = document.createElement('td');
            cellDescripcion.textContent = movimiento.descripcion;
            row.appendChild(cellDescripcion);

            const monto = document.createElement('td');
            monto.textContent = movimiento.monto;
            row.appendChild(monto);

            const tipoMovimiento = document.createElement('td');
            tipoMovimiento.textContent = movimiento.tipo_movimiento;
            row.appendChild(tipoMovimiento);

            //agregarlas
            movimientosTableBody.appendChild(row);
          });
          fetch(`/caja/${id}/monto`)
            .then(response => response.json())
            .then(montos => {
              console.log(montos);

              let h4Monto = document.getElementById("h4Inicial")
              h4Monto.innerHTML = ``;
              h4Monto.textContent = `Monto Inicial: ${montos.monto_inicial}`;
              h4Monto.classList.add("bg-dark");
              h4Monto.classList.add("text-white");

              let h5Monto = document.getElementById("h5Monto");
              h5Monto.innerHTML = ``;
              h5Monto.classList.add("bg-dark");
              h5Monto.classList.add("text-white");
              h5Monto.textContent = `Monto final: ${montos.monto_final}`;
            });
          // Mostrar el modal
          $('#modalVerMovimiento').modal();
        })
        .catch(error => console.error('Error al obtener movimientos:', error));
    });
  });
</script>
@endsection