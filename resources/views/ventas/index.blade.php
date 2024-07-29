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
      <form action="{{route('storeVentaDetalle')}}" method="POST">
        @csrf
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
          <tbody id="tbody">
            <tr class="template-row">
              <td>
                <button class="btn" onclick="eliminarFila(this)">
                  <i class="bi bi-bag-x" style="font-size: 2rem; color: cornflowerblue;"></i>
                </button>
              </td>
              <td class="small-width">
                <select name="compra-select[]" id="compra-select" class="form-select form-select-sm">
                  <option value="" selected>Seleccione</option>
                  @foreach ($compras as $compra)
            <option value="{{ $compra->id }}">{{ $compra->id }}</option>
          @endforeach
                </select>
              </td>
              <td class="min-width">
                <input type="text" name="proveedor[]" class="form-control form-control-sm">
              </td>
              <td class="min-width">
                <input type="text" name="marca[]" class="form-control form-control-sm">
              </td>
              <td class="min-width">
                <input type="text" name="producto[]" class="form-control form-control-sm">
              </td>
              <td class="min-width">
                <input type="text" name="aroma[]" class="form-control form-control-sm">
              </td>
              <td class="small-width">
                <input type="number" name="stock[]" class="form-control form-control-sm">
              </td>
              <td class="min-width">
                <input type="number" name="precio[]" class="form-control form-control-sm">
              </td>
              <td class="small-width">
                <input type="number" name="cantidad[]" class="form-control form-control-sm">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="form-group">
          <button type="button" class="btn btn-primary mr-2" onclick="agregarFila()">Agregar Fila</button>
          <input type="submit" value="Guardar" class="btn btn-success">
        </div>
      </form>
    </div>
  </div>
 
  <div id="compra-details">

  </div>
  <script>
    document.getElementById('tbody').addEventListener('change', function (event) {
      if (event.target && event.target.matches('select[name="compra-select[]"]')) {
        let id = event.target.value;
        console.log("Valor seleccionado:", id);
        fetch(`/getCompraData/${id}`)
          .then(response => {
            if (!response.ok) {
              throw new Error(`Error en la solicitud: ${response.status}`);
            }
            return response.json();
          })
          .then(data => {
            const compraDetails = data.compra;
            const currentRow = event.target.closest('tr'); // Encuentra la fila actual

            const proveedor = currentRow.querySelector('input[name="proveedor[]"]');
            proveedor.value = compraDetails.proveedor_id;

            const marca = currentRow.querySelector('input[name="marca[]"]');
            marca.value = compraDetails.marca_id;

            const producto = currentRow.querySelector('input[name="producto[]"]');
            producto.value = compraDetails.producto_id;

            const aroma = currentRow.querySelector('input[name="aroma[]"]');
            aroma.value = compraDetails.aroma_id;

            const stock = currentRow.querySelector('input[name="stock[]"]');
            stock.value = compraDetails.cantidad;

            const precio = currentRow.querySelector('input[name="precio[]"]');
            precio.value = compraDetails.precio_costo;

            // Cálculos
            document.getElementById('tbody').addEventListener('input', function (event) {
              if (event.target && event.target.matches('input[name="cantidad[]"]')) {
                actualizarTotal();
              }
            });

            function actualizarTotal() {
              let totalGeneral = 0;

              // Recorre todas las filas y suma los totales
              document.querySelectorAll('#tbody tr').forEach(row => {
                const cantidad = row.querySelector('input[name="cantidad[]"]').value;
                const precio = row.querySelector('input[name="precio[]"]').value;
                const subtotal = cantidad * precio;
                // Agrega el subtotal al total general
                totalGeneral += subtotal;
              });

              // Muestra el total general 
              const compraDetailsDiv = document.getElementById('compra-details');
              compraDetailsDiv.innerHTML = `
                        <h3>Detalles de la Venta</h3>
                        <p>TOTAL: ${totalGeneral}</p>
                        `;
            }
          })
          .catch(error => console.error('Error fetching data:', error));
      }
    });


    function agregarFila() {
      // Obtén la fila de plantilla
      var templateRow = document.querySelector('.template-row');
      // Clona la fila de plantilla
      var newRow = templateRow.cloneNode(true);
      // Limpia los valores de los inputs en la nueva fila
      newRow.querySelectorAll('input').forEach(input => input.value = '');
      newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

      // Añade la nueva fila al tbody
      document.getElementById('tbody').appendChild(newRow);
    }

    function eliminarFila(button) {
      // Elimina la fila correspondiente al botón de eliminar
      button.closest('tr').remove();
    }
  </script>
  @endsection