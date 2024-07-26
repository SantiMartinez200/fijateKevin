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
    /* Define el ancho mínimo de las celdas */
    max-width: 130px;
    /* Define el ancho máximo de las celdas */
  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .small-width {
    width: 60px;
    /* Ancho fijo para celdas pequeñas */
  }

  select,
  input[type="number"],
  input[type="text"] {
    max-width: 100%;
    /* Asegura que el input no exceda el ancho de la celda */
    padding: 0.25rem;
    /* Ajuste del padding para minimizar el tamaño */
  }
</style>
</head>

<body>
  <div class="container mt-5">
    <div class="table-responsive shadow p-3 mb-5 bg-white rounded">
      <table class="table table-striped text-center">
        <thead>
          <tr>
            <th scope="col">X</th>
            <th scope="col" class="small-width">N° Compra</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Marca</th>
            <th scope="col">Producto</th>
            <th scope="col">Aroma</th>
            <th scope="col" class="small-width">Stock</th>
            <th scope="col" class="small-width">Precio</th>
            <th scope="col" class="small-width">C/Venta</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <button class="btn">
                <i class="bi bi-bag-x" style="font-size: 2rem; color: cornflowerblue;"></i>
              </button>
            </td>
            <td class="small-width">
              <select name="compra-select" id="compra-select" class="form-select form-select-sm">
                <option value="" selected>Seleccione</option>
                @foreach ($compras as $compra)
          <option value="{{ $compra->id }}">{{ $compra->id }}</option>
        @endforeach
              </select>
            </td>
            <td class="min-width">
              <input type="text" id="proveedor" class="form-control form-control-sm">
            </td>
            <td class="min-width">
              <input type="text" id="marca" class="form-control form-control-sm">
            </td>
            <td class="min-width">
              <input type="text" id="producto" class="form-control form-control-sm">
            </td>
            <td class="min-width">
              <input type="text" id="aroma" class="form-control form-control-sm">
            </td>
            <td class="small-width">
              <input type="number" id="stock" class="form-control form-control-sm">
            </td>
            <td class="min-width">
              <input type="number" id="precio" class="form-control form-control-sm">
            </td>
            <td class="small-width">
              <input type="number" id="cantidad" class="form-control form-control-sm">
            </td>
          </tr>
          <tr>
            <td>
              <button class="btn">
                <i class="bi bi-bag-plus" style="font-size: 2rem; color: cornflowerblue;"></i>
              </button>
            </td>
            <!-- Agrega más celdas aquí si es necesario -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div id="compra-details">

  </div>
  <script>
    document.getElementById('compra-select').addEventListener('change', function () {
      const id = this.value;
      fetch(`getCompraData/${id}`)
        .then(response => response.json())
        .then(data => {
          // Manejo de los datos de la compra
          const compraDetails = data.compra;
          const proveedor = document.getElementById('proveedor');
          proveedor.value = compraDetails.proveedor_id;
          const marca = document.getElementById('marca');
          marca.value = compraDetails.marca_id;
          const producto = document.getElementById('producto');
          producto.value = compraDetails.producto_id;
          const aroma = document.getElementById('aroma');
          aroma.value = compraDetails.aroma_id;
          const stock = document.getElementById('stock');
          stock.value = compraDetails.cantidad;
          const precio = document.getElementById('precio');
          precio.value = compraDetails.precio_costo;

          // Manejo de Cálculos
          let input = document.getElementById('cantidad').addEventListener('input', function () {
            const cantidad = this.value;
            const precio = document.getElementById('precio').value;
            const total = cantidad * precio;
            const compraDetailsDiv = document.getElementById('compra-details');
            compraDetailsDiv.innerHTML = `
              <h3>Detalles de la Venta</h3>
              <p>TOTAL: ${total}</p>
          `;
          });
        })
        .catch(error => console.error('Error fetching data:', error));
    });
  </script>
  @endsection