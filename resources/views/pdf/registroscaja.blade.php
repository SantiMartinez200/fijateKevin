<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="card w-100" id="card" tabindex="-1" role="dialog">
    <div class="">
      <div class="card-header">
        <h5 class="h5">Movimientos de Caja <span id="fecha-caja">{{$datosAdicionales["caja_fecha"]}}</span></h5>
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
            @foreach($movimientos as $movimiento)
            <tr>
        <td>{{$movimiento->descripcion}}</td>
        <td>{{$movimiento->monto}}</td>
        <td>{{$movimiento->tipo_movimiento}}</td>
      </tr>
      @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <h5 class="form-control mb-2" id="h5Monto">Monto total actualizado: <span id="monto-final"></span></h5>
      </div>
    </div>
  </div>
</body>

</html>