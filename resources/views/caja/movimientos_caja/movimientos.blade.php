@extends('layouts.app')
@section('content')
<div class="card w-100" id="card" tabindex="-1" role="dialog">

  <div class="">
    <div class="card-header">
      <h5 class="h5">Movimientos de Caja <span id="fecha-caja" ></span></h5>
      <br>
      <h5 class="form-control" id="h5Inicial">Monto Inicial: <span id="monto-inicial"></span></h5>
    </div>
    <div class="card-body">
      <table class="table table-bordered" id="movimientosTable">
        <thead id="table-head">
          <tr>
            <th>Descripción</th>
            <th>Monto</th>
            <th>Tipo de Movimiento</th>
          </tr>
        </thead>
        <tbody>
          <!--Filas agregadas desde js fetch-->
        </tbody>
      </table>
    </div>
    <div class="card-footer">
      <h5 class="form-control mb-2" id="h5Monto">Monto total actualizado: <span id="monto-final"></span></h5>
      <a href="{{route('registros-caja',1)}}" type="button" class="btn btn-danger" style="font-size: 30px;"><i class="bi bi-filetype-pdf"></i></a>
    </div>
  </div>
</div>
<script>
  let id = location.href.slice(-1);
  fetch(`caja/${id}/movimientos`).then((response) => response.json()).then(data => {
    let fecha_caja = document.getElementById("fecha-caja");
    fecha_caja.innerHTML = data.datosAdicionales.caja_fecha;
    let table = document.getElementById("movimientosTable");
    let tbody = table.getElementsByTagName("tbody")[0];
    data.movimientos.forEach(movimientos => {
      let row = tbody.insertRow();
      let descripcionCell = row.insertCell(0);
      let montoCell = row.insertCell(1);
      let tipoMovimientoCell = row.insertCell(2);
      descripcionCell.innerHTML = movimientos.descripcion;
      montoCell.innerHTML = movimientos.monto;
      tipoMovimientoCell.innerHTML = movimientos.tipo_movimiento;
    })
  })

  fetch(`caja/${id}/monto`).then((response) => response.json()).then(data => {
    document.getElementById("monto-inicial").innerHTML = data.monto_inicial;
    document.getElementById("monto-final").innerHTML = data.monto_final;
  })
</script>
@endsection