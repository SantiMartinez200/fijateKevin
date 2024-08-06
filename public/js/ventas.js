function fetchURL() {
    document
        .getElementById("tbody")
        .addEventListener("change", function (event) {
            if (
                event.target &&
                event.target.matches('select[name="compra-select[]"]')
            ) {
                let id = event.target.value;
                document
                    .getElementById("tbody")
                    .addEventListener("keydown", function (event) {
                        if (event.key === "-") {
                            event.preventDefault();
                        }
                    });
                fetch(`/getCompraData/${id}`)
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(
                                `Error en la solicitud: ${response.status}`
                            );
                        }
                        return response.json();
                    })
                    .then((data) => {
                        const compraDetails = data.compra;
                        const currentRow = event.target.closest("tr"); // Encuentra la fila actual

                        const proveedor = currentRow.querySelector(
                            'input[name="proveedor[]"]'
                        );
                        proveedor.value = compraDetails.proveedor_id;

                        const marca = currentRow.querySelector(
                            'input[name="marca[]"]'
                        );
                        marca.value = compraDetails.marca_id;

                        const producto = currentRow.querySelector(
                            'input[name="producto[]"]'
                        );
                        producto.value = compraDetails.producto_id;

                        const aroma = currentRow.querySelector(
                            'input[name="aroma[]"]'
                        );
                        aroma.value = compraDetails.aroma_id;

                        const stock = currentRow.querySelector(
                            'input[name="stock[]"]'
                        );
                        stock.value = compraDetails.cantidad;

                        const precio = currentRow.querySelector(
                            'input[name="precio[]"]'
                        );
                        precio.value = compraDetails.precio_venta;

                        // Cálculos
                        document
                            .getElementById("tbody")
                            .addEventListener("input", function (event) {
                                if (
                                    event.target &&
                                    event.target.matches(
                                        'input[name="cantidad[]"]'
                                    )
                                ) {
                                    console.log("c");
                                    verificarCantidad();
                                }
                            });
                    })
                    .catch((error) =>
                        console.error("Error fetching data:", error)
                    );
            }
        });
}
fetchURL();

function actualizarTotal() {
    let totalGeneral = 0;
    // Recorre todas las filas y suma los totales
    document.querySelectorAll("#tbody tr").forEach((row) => {
        const cantidad = row.querySelector('input[name="cantidad[]"]').value;
        const precio = row.querySelector('input[name="precio[]"]').value;
        const subtotal = cantidad * precio;
        totalGeneral += subtotal;
    });
    // Muestra el total general
    if (totalGeneral > 0) {
        document.getElementById("total-compraLabel").hidden = false;
        const compraDetailsInput = document.getElementById("total-compra");
        compraDetailsInput.value = totalGeneral;
        compraDetailsInput.hidden = false;
    } else {
        document.getElementById("total-compraLabel").hidden = true;
        document.getElementById("total-compra").hidden = true;
    }
}

function agregarFila() {
    // Obtener fila
    var templateRow = document.querySelector(".template-row");
    // Clonar fila
    var newRow = templateRow.cloneNode(true);
    // Limpiar fila nueva
    newRow.querySelectorAll("input").forEach((input) => (input.value = ""));
    newRow
        .querySelectorAll("select")
        .forEach((select) => (select.selectedIndex = 0));
    // Añadir fila a la tabla
    document.getElementById("tbody").appendChild(newRow);
}

function eliminarFila(button) {
    let rowCount = document.querySelectorAll("#tbody tr").length;
    if (rowCount == 1) {
        console.log(rowCount);
        alert("No se puede eliminar la última fila.");
    } else {
        // Elimina la fila correspondiente al botón de eliminar
        button.closest("tr").remove();
        // actualiza el total
        actualizarTotal();
    }
}

function verificarCantidad() {
    let rows = document.querySelectorAll("#tbody tr");
    rows.forEach((row) => {
        // Obtener inputs de cantidad&stock
        let cantidadInput = row.querySelector('input[name="cantidad[]"]');
        let stockInput = row.querySelector('input[name="stock[]"]');
        let cantidad = parseInt(cantidadInput.value);
        let stock = parseInt(stockInput.value);
        if (cantidad > stock) {
            //se remueve el último caracter en caso de que la cantidad ingresada supere al stock.
            event.target.value = cantidadInput.value.slice(0, -1);
        } else {
            actualizarTotal();
        }
    });
}
