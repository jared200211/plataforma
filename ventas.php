<!doctype html>
<html lang="es">
<head>
    <title>VENTAS IBARRA</title>
    <style>
        body {
            overflow: hidden;
        }
        .tabla-scrollable {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .total-container {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<main>
    <div class="tabla-conte">
        <div class="row mb-3">
            <div class="col">
                <div class="row mb-3 align-items-end">
                    <div class="col-md-4">
                        <label for="tcodigo" class="form-label">Código</label>
                        <input type="text" id="codigo" class="form-control w-50">
                    </div>
                    <div class="col-md-4">
                        <label for="producto" class="form-label">Productos</label>
                        <select id="producto" class="form-select">
                            <option selected disabled>Selecciona un producto</option>
                            <!-- Los productos se cargarán aquí mediante JS -->
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="me-2">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" id="cantidad" class="form-control w-50" min="1">
                        </div>
                        <button type="button" id="agregar" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabla-scrollable">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Importe</th>
                        <th>Acciones</th> <!-- Columna para el botón de eliminar -->
                    </tr>
                </thead>
                <tbody id="tableD">
                    <!-- Aquí se cargarán los datos con JavaScript -->
                </tbody>
            </table>
        </div>
        
        <div class="total-container">
            Total: <span id="total">0</span>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex">
            <div class="form-group me-3">
                <label for="vendedor" class="form-label">Vendedor</label>
                <select id="vendedor" class="form-select">
                    <option selected>Alejandro</option>
                    <option value="Joss">Joss</option>
                    <option value="Adrian">Adrian</option>
                    <option value="Ruben">Ruben</option>
                </select>
            </div>
            <div class="form-group me-3">
                <label for="tipoPago" class="form-label">Tipo de Pago</label>
                <select id="tipoPago" class="form-select">
                    <option selected>Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>
        </div>
        <div>
            <button type="button" class="btn btn-primary me-3">Comprobante</button>
            <button type="button" class="btn btn-success" id="realizarVenta">Realizar Venta</button>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// Variables globales
const tableBody = document.getElementById("tableD");
const totalElement = document.getElementById("total");
let totalVenta = 0; // Total de la venta
let productosVenta = []; // Array para almacenar los productos de la venta (solo los de la tabla)

// Cargar los productos desde la base de datos
$(document).ready(function() {
    $.ajax({
        url: 'conexioon.php', // Ruta al archivo PHP que devuelve los productos
        method: 'GET',
        success: function(response) {
            let productosBD = JSON.parse(response); // productosBD es la lista de productos en la base de datos
            const productoSelect = $('#producto');

            // Limpiar opciones existentes
            productoSelect.empty();
            
            // Agregar opción por defecto
            productoSelect.append('<option selected disabled>Selecciona un producto</option>');
            
            // Agregar productos al select
            productosBD.forEach(function(producto) {
                productoSelect.append(
                    `<option value="${producto.id_producto}" data-nombre="${producto.nombre_producto}" data-precio="${producto.precio_unitario}">${producto.nombre_producto}</option>`
                );
            });
        },
        error: function(xhr, status, error) {
            alert("Error al cargar los productos");
        }
    });
});

// Función para agregar el producto a la tabla
// Función para agregar el producto a la tabla
document.getElementById("agregar").addEventListener("click", function() {
    const codigo = document.getElementById("codigo").value; // Obtener el valor de id_producto
    const productoSelect = document.getElementById("producto");
    const cantidad = parseInt(document.getElementById("cantidad").value);  // Obtener la cantidad

    if (!cantidad || cantidad <= 0) {
        alert("Por favor, ingrese una cantidad válida.");
        return;
    }

    let nombreProducto = '';
    let precioUnitario =parseFloat(producto.dataset.precio);

    if (codigo) {
        // Si hay un código (id_producto), busca el producto
        $.ajax({
            url: 'conexioon.php', // Ruta del archivo PHP para obtener el producto
            method: 'GET',
            data: { codigo: codigo },  // Enviar id_producto al servidor
            success: function(response) {
                const producto = JSON.parse(response);
                if (producto.error) {
                    alert("Producto no encontrado con el ID proporcionado.");
                } else {
                    nombreProducto = producto.nombre_producto;
                    precioUnitario = producto.precio_unitario;
                    agregarProducto(producto.id_producto, nombreProducto, precioUnitario, cantidad);
                }
            },
            error: function(xhr, status, error) {
                alert("Error al buscar el producto por ID.");
            }
        });
    } else if (productoSelect.selectedIndex !== 0) {
        // Si no hay código, obtiene el producto seleccionado del select
        const producto = productoSelect.selectedOptions[0];
        const idProducto = producto.value;
        nombreProducto = producto.dataset.nombre;
        precioUnitario = producto.dataset.precio;

        agregarProducto(idProducto, nombreProducto, precioUnitario, cantidad);
    } else {
        alert("Por favor, ingrese un código o seleccione un producto.");
    }
});


// Función para agregar el producto a la tabla
function agregarProducto(idProducto, nombreProducto, precioUnitario, cantidad) {
    if (isNaN(precioUnitario) || precioUnitario < 0) {
        alert("El precio del producto no es válido");
        return;
    }

    // Calcular el importe
    const importe = (precioUnitario * cantidad);

    // Crear una nueva fila en la tabla
    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${idProducto || 'N/A'}</td>
        <td>${nombreProducto}</td>
        <td>${cantidad}</td>
        <td>$${precioUnitario}</td>
        <td>$${importe.toFixed(2)}</td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this, ${importe})">Eliminar</button></td> <!-- Botón eliminar -->
    `;

    // Agregar la fila a la tabla
    tableBody.appendChild(row);

    // Actualizar el total de la venta  
    totalVenta += importe;
    totalElement.textContent = `$${totalVenta.toFixed(2)}`;

    // Agregar el producto al array de productos de la venta (solo productos de la tabla)
    productosVenta.push({
        id_producto: idProducto,
        nombre_producto: nombreProducto,
        cantidad: cantidad,
        precio_unitario: precioUnitario,
        total_producto: importe
    });

    // Limpiar los campos
    document.getElementById("codigo").value = '';  // Limpiar el campo código
    document.getElementById("producto").value = '';  // Limpiar el select
    document.getElementById("cantidad").value = '';  // Limpiar la cantidad
}

// Función para eliminar un producto
function eliminarProducto(button, importe) {
    // Eliminar la fila de la tabla
    const row = button.closest("tr");
    row.remove();

    // Actualizar el total
    totalVenta -= importe;
    totalElement.textContent = `$${totalVenta.toFixed(2)}`;

    // Eliminar el producto del array
    const idProducto = row.cells[0].textContent;  // Obtener el ID del producto
    productosVenta = productosVenta.filter(producto => producto.id_producto !== idProducto);
}

// Función para realizar la venta y guardar en la base de datos
// Función para realizar la venta y guardar en la base de datos


</script>
<script>
    document.getElementById("realizarVenta").addEventListener("click", function() {
    const vendedor = document.getElementById("vendedor").value;
    const tipoPago = document.getElementById("tipoPago").value;

    if (productosVenta.length === 0) {
        alert("Por favor, agregue productos antes de realizar la venta.");
        return;
    }

    console.log("Datos enviados al servidor:", {
        vendedor: vendedor,
        tipo_pago: tipoPago,
        total: totalVenta,
        productosVenta: JSON.stringify(productosVenta) // Solo los productos de la tabla
    });

    // Enviar los datos de la venta al servidor
    $.ajax({
        url: 'realizar_venta.php', // Ruta al archivo PHP para insertar la venta
        method: 'POST',
        data: {
            vendedor: vendedor,
            tipo_pago: tipoPago,
            total: totalVenta,
            productosVenta: JSON.stringify(productosVenta) // Solo los productos de la venta
        },
        success: function(response) {
            console.log("Respuesta del servidor:", response);
            
            if (response.success) {  // Verificar que la venta fue exitosa
                alert("Venta realizada con éxito.");
                // Resetear los datos locales
                totalVenta = 0;
                productosVenta = [];
                tableBody.innerHTML = '';
                totalElement.textContent = `$${totalVenta.toFixed(2)}`;
            } else {
                alert("Error al realizar la venta: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", error);
            alert("Ocurrió un error al procesar la venta.");
        }
    });
}); // <-- Esta llave cierra el addEventListener

</script>


</body>
</html>
