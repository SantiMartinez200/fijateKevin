function fetchSalidas() {
    fetch("comprobantes")
        .then((response) => response.json())
        .then((data) => {
            const tbody = document.getElementById("bodyTabla");
            data.forEach((e) => {
                const row = document.createElement("tr");

                let cod_compra = document.createElement("td");
                let fecha_venta = document.createElement("td");
                let marca = document.createElement("td");
                let producto = document.createElement("td");
                let total_precio = document.createElement("td");
                let total_cantidades = document.createElement("td");

                let button_accion_td = document.createElement("td");
                let button_accion = document.createElement("button");
                let icon = document.createElement("i");
                icon.classList.add("bi", "bi-filetype-pdf", "h2");
                button_accion.classList.add("btn", "btn-primary");

                cod_compra.textContent = e.compra_detalle_id;
                marca.textContent = e.nombre_marca;
                producto.textContent = e.nombre_producto;
                fecha_venta.textContent = e.created_at;
                total_precio.textContent = e.precio_venta;
                total_cantidades.textContent = e.cantidad;

                row.appendChild(cod_compra);
                row.appendChild(fecha_venta);
                row.appendChild(marca);
                row.appendChild(producto);
                row.appendChild(total_precio);
                row.appendChild(total_cantidades);
                button_accion.appendChild(icon);
                button_accion_td.appendChild(button_accion);
                row.appendChild(button_accion_td);

                tbody.appendChild(row);
            });
        });
}
fetchSalidas();
