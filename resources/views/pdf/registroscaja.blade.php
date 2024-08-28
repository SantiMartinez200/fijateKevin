<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pdf_Caja{{$datosAdicionales["caja_fecha"]}}</title>
</head>
<style>
  body {
    font-family: monospace;
  }

  .container {
    min-width: 415px;
    max-width: 75%;
    border: 1px solid;
    border-color: #808d7c;
    margin: 0 auto;
  }

  .header {
    background-color: #5f6f65;
    display: grid;
    grid-template-columns: auto auto auto;
    text-align: center;
    border: 1px solid;
  }

  .footer {
    background-color: #5f6f65;
  }

  img,
  .title,
  .amount {
    min-width: 100px;
  }

  img {
    width: 100px;
    height: 100px;
  }

  .amount-span {
    font-size: 3rem;
  }

  .title,
  .amount {
    margin-top: auto;
    margin-bottom: auto;
  }

  .body,
  .footer {
    border: 2px solid;
  }

  .title,
  .amount {
    font-size: 18px;
    font-weight: 500;
    color: #fff;
  }

  .title-content,
  .amount-span {
    font-weight: 500;
  }

  .title,
  .title-content {
    text-align: start;
    padding-left: 0.5rem;
  }

  .amount {
    text-align: end;
    padding-right: 0.5rem;
  }

  .body {
    display: grid;
    grid-template-columns: 1fr;
    text-align: center;
  }

  table {
    width: 100%;
    border: 1px solid;
    border-collapse: collapse;
  }

  th,
  tr,
  td {
    font-size: 15px;
    border: 1px solid;
    padding: 8px;
    text-align: center;
  }

  .grid-item {
    font-size: 14px;
    font-weight: 700;
    border: 1px solid;
    word-wrap: break-word;
  }

  .responsible {
    margin: 2px;
  }
</style>

<body>
  <div class="container">
    <div class="header">
      <table>
        <tr>
          <td class="title">
            Comprobante de la Caja N°<br />
            <span class="title-content">
              @if(count($movimientos) > 0)
          {{$movimientos[0]->caja_id}}
        @else
        {{$caja->id}}
      @endif
            </span>
            <br />
            <span class="title">Al</span> <br /><span class="title-content">{{$datosAdicionales["caja_fecha"]}}</span>
            <div class="responsible">
              Caja abierta por:<span class="title-content">Brago</span>
            </div>
          </td>
          <td class="logo"><img src="{{ public_path('img/logo-tribal-essence-white.jpg') }}" alt="" /></td>
          <td class="amount">
            Monto al inicio del período: <br /><span class="amount-span">{{$montos["monto_inicial"]}}</span>
          </td>
        </tr>
      </table>
    </div>
    <div class="body">
      <table>
        <thead>
          <th>Descripcion</th>
          <th>Monto</th>
          <th>Tipo de Movimiento</th>
        </thead>
        <tbody>
          @forelse($movimientos as $movimiento)
        <tr>
        <td>{{$movimiento->descripcion}}</td>
        <td>{{$movimiento->monto}}</td>
        <td>{{$movimiento->tipo_movimiento}}</td>
        </tr>
      @empty
      <tr>
      <td>
        No se registran Movimientos para la caja
      </td>
      <td>0</td>
      <td>N/D</td>
      </tr>
  @endforelse
        </tbody>
      </table>
    </div>
    <div class="footer">
      <div class="title">
        <div>
          <h3>Monto Final: {{$montos["monto_final"]}}</h3>
        </div>
      </div>
    </div>
  </div>
</body>

</html>