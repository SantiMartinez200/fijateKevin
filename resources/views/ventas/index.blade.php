@extends('layouts.app')
@section('content')

@if ($message = Session::get('message'))
  <div class="alert alert-success" role="alert">
    {{ $message }}
  </div>
@endif
<style>
  /* CSS personalizado para ajustar los tamaños de las columnas */
  .min-width {
    min-width: 80px;
    max-width: 130px;
  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .small-width {
    width: 60px;
  }

  select,
  input[type="number"],
  input[type="text"] {
    max-width: 100%;
    padding: 0.25rem;
  }
</style>
</head>

<body>
  <div class="container mt-5">
    <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
      <div class="d-flex align-items-center">
        <h4 class="h4 m-1">¿Cómo buscar?</h4>
        <button class="btn btn-outline-primary m-1 p-0" style="font-size:25px;"><i class="bi bi-question"></i></button>
      </div>
      <form action="{{route('storeVentaDetalle')}}" method="POST" autocomplete="off">
        @csrf
        <table class="table table-striped text-center">
          <thead>
            <tr>
              <th scope="col">X</th>
              <th scope="col" class="small-width">N° Producto</th>
              <th scope="col">Proveedor</th>
              <th scope="col">Marca</th>
              <th scope="col">Producto</th>
              <th scope="col">Aroma</th>
              <th scope="col" class="small-width">Stock</th>
              <th scope="col" class="small-width">Precio <br> de Venta</th>
              <th scope="col" class="small-width">C/Venta</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr class="template-row">
              <td>
                <button class="btn" onclick="eliminarFila(this)" tabindex="-1">
                  <i class="bi bi-bag-x" style="font-size: 2rem; color: red;"></i>
                </button>
              </td>
              <td class="small-width">
                <input type="text" name="search[]" id="compra-select" class="">
                <div id="fetch" class="fetch block">
                  <ul class="text-start ulSuggest" style="width:500px;" id="ulSuggest" hidden></ul>
                </div>
              </td>
              <td class="hidden">
                <input type="text" name="compra-select[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="compra">
              </td>
              <td class="min-width">
                <input type="text" name="proveedor[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="proveedor">
              </td>
              <td class="min-width">
                <input type="text" name="marca[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="marca">
              </td>
              <td class="min-width">
                <input type="text" name="producto[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="producto">
              </td>
              <td class="min-width">
                <input type="text" name="aroma[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="aroma">
              </td>
              <td class="small-width">
                <input type="number" name="stock[]" class="form-control form-control-sm" readonly tabindex="-1"
                  id="stock">
              </td>
              <td class="min-width">
                <input type="number" name="precio[]" class="form-control form-control-sm" tabindex="-1" id="precio">
              </td>
              <td class="small-width">
                <input type="number" name="cantidad[]" class="form-control form-control-sm" pattern="^[0-9]" min="1"
                  tabindex="-1">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="form-group">
          <button type="button" class="btn btn-primary mr-2" onclick="agregarFila()" id="agregar">Agregar Fila</button>
          <input type="submit" value="Guardar" class="btn btn-success" id="guardar">
          <div class="container" id="">
            <div class="d-flex align-items-center mt-2">
              <p id="handle" class="text text-danger" hidden></p>
              <label class="mt-2" for="total-compra" id="total-compraLabel" hidden>TOTAL: </label>
              <input type="number" name="total-compra" id="total-compra" value=""
                class="form-control form-control-sm w-25 ml-1" readonly hidden>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="{{asset('js/ventas.js')}}"></script>
  @endsection