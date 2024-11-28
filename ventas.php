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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

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
                    <option value="Alejandro" selected>Alejandro</option>
                    <option value="Joss">Joss</option>
                    <option value="Adrian">Adrian</option>
                    <option value="Ruben">Ruben</option>
                </select>
            </div>
            <div class="form-group me-3">
                <label for="tipoPago" class="form-label">Tipo de Pago</label>
                <select id="tipoPago" class="form-select">
                    <option value="Efectivo" selected>Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                </select>
            </div>
        </div>
        <div>
            <!-- <button type="button" class="btn btn-primary me-3">Comprobante</button> -->
            <button type="button" class="btn btn-success" id="realizarVenta">Realizar Venta</button>
        </div>
    </div>

    <!-- Modal de éxito -->
<div class="modal fade" id="ventaExitosaModal" tabindex="-1" aria-labelledby="ventaExitosaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ventaExitosaLabel">¡Venta realizada con éxito!</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        La venta se ha registrado correctamente.
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" id="btnTicket">Ticket</button>
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Ok</button>
       
      </div>
    </div>
  </div>
</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
      
      $(document).ready(function() {
    let productos = []; // Aquí almacenaremos los productos
    let productosSeleccionados = []; // Productos que se han agregado a la tabla
    let total = 0; // Total de la venta

    // Función para cargar productos desde la base de datos
    function cargarProductos() {
        $.ajax({
            url: 'conexioon.php', // Cambia esto por la URL de tu endpoint que devuelva los productos
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                productos = data;
                // Rellenar el select de productos
                let options = '<option selected disabled>Selecciona un producto</option>';
                productos.forEach(function(producto) {
                    options += `<option value="${producto.id_producto}">${producto.nombre_producto} - $${producto.precio_unitario}</option>`;
                });
                $('#producto').html(options);
            },
            error: function() {
                alert('Error al cargar los productos.');
            }
        });
    }

    // Llamar a la función para cargar productos al iniciar la página
    cargarProductos();

    // Función para agregar un producto a la tabla
    $('#agregar').click(function() {
        let codigo = $('#codigo').val().trim();
        let productoId = $('#producto').val();
        let cantidad = parseInt($('#cantidad').val());

        if (!cantidad || cantidad <= 0) {
            alert('Por favor ingresa una cantidad válida.');
            return;
        }

        if ((codigo && productoId) || (!codigo && !productoId)) {
            alert('Por favor, selecciona un solo método: código o producto.');
            return;
        }

        let productoSeleccionado;
        if (codigo) {
            // Buscar producto por código
            productoSeleccionado = productos.find(producto => producto.codigo === codigo);
        } else if (productoId) {
            // Buscar producto por ID
            productoSeleccionado = productos.find(producto => producto.id_producto == productoId);
        }

        if (productoSeleccionado) {
            // Agregar producto a la tabla
            let importe = productoSeleccionado.precio_unitario * cantidad;
            productosSeleccionados.push({
                id_producto: productoSeleccionado.id_producto,
                nombre_producto: productoSeleccionado.nombre_producto,
                cantidad: cantidad,
                precio_unitario: productoSeleccionado.precio_unitario,
                total_producto: importe
            });

            // Actualizar la tabla y el total
            actualizarTabla();
            $('#codigo').val(''); // Limpiar código
            $('#producto').val(''); // Limpiar selección de producto
            $('#cantidad').val(''); // Limpiar cantidad
        } else {
            alert('Producto no encontrado.');
        }
    });

    // Función para actualizar la tabla y el total
    function actualizarTabla() {
        let tableBody = $('#tableD');
        tableBody.empty();
        total = 0;
        productosSeleccionados.forEach((producto, index) => {
            tableBody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${producto.nombre_producto}</td>
                    <td>${producto.cantidad}</td>
                    <td>$${producto.precio_unitario}</td>
                    <td>$${producto.total_producto.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})">Eliminar</button></td>
                </tr>
            `);
            total += producto.total_producto;
        });

        $('#total').text(total.toFixed(2));
    }

    // Función para eliminar un producto de la tabla
    window.eliminarProducto = function(index) {
        productosSeleccionados.splice(index, 1);
        actualizarTabla();
    };

    // Función para realizar la venta
    $('#realizarVenta').click(function() {
        if (productosSeleccionados.length === 0) {
            alert('No hay productos en la venta.');
            return;
        }

        let vendedor = $('#vendedor').val();
        let tipoPago = $('#tipoPago').val();

        // Enviar datos de la venta al servidor
        $.ajax({
            url: 'realizar_venta.php', // Cambia esto por la URL de tu endpoint para guardar la venta
            method: 'POST',
            data: {
                vendedor: vendedor,
                tipo_pago: tipoPago,
                total: total,
                productos: productosSeleccionados
            },
            success: function(response) {
                // Mostrar el modal de éxito, pero sin permitir que se cierre
                let modal = new bootstrap.Modal(document.getElementById('ventaExitosaModal'), {
                    backdrop: 'static', // Evita que se cierre al hacer clic fuera
                    keyboard: false // Evita que se cierre al presionar ESC
                });
                modal.show(); // Mostrar el modal de éxito
            },
            error: function() {
                alert('Error al realizar la venta.');
            }
        });
    });

    // Función para generar el PDF del ticket
    $('#btnTicket').click(function() {
        // Asegurarse de que productosSeleccionados está definido
        if (productosSeleccionados.length === 0) {
            alert('No hay productos seleccionados para generar el ticket.');
            return;
        }

        // Crear un objeto PDF con jsPDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Definir la fecha y hora actual
        const fechaHora = new Date();
        const fecha = fechaHora.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        const hora = fechaHora.toLocaleTimeString('es-ES');
        
        // Título del ticket
        doc.setFontSize(18);  
doc.text('Grupo Industrial Ibarra', 14, 10);  // Nombre de la empresa
doc.setFontSize(12);  
doc.text('Calle Roque Rubio No.58', 14, 16);  // Dirección
doc.text('Casa Blanca, Queretaro.', 14, 22);  // Localidad y ciudad


doc.setFontSize(12);  
doc.text(`Fecha: ${fecha}`, 14, 30);  
doc.text(`Hora: ${hora}`, 14, 35);  

        
        // Información de la venta
        doc.text('Detalle de la venta:', 14, 40);
        let yPosition = 50; // Posición inicial para los productos
        
        let cantidadProductos = productosSeleccionados.length;
        let totalVenta = 0;

        // Recorrer los productos seleccionados y agregar al PDF
        productosSeleccionados.forEach((producto, index) => {
            doc.text(`${index + 1}. ${producto.nombre_producto}`, 14, yPosition);
            doc.text(`Cantidad: ${producto.cantidad}`, 100, yPosition);
            doc.text(`$${producto.total_producto.toFixed(2)}`, 140, yPosition);
            yPosition += 10;
            totalVenta += producto.total_producto;
        });

        // Total de la venta
        doc.text(`Total: $${totalVenta.toFixed(2)}`, 14, yPosition + 10);
        doc.text(`Cantidad de productos: ${cantidadProductos}`, 14, yPosition + 20);

        // Descargar el PDF
        doc.save('ticket_venta.pdf');
    });

    // Limpiar los productos cuando el usuario hace clic en "Ok" del modal
    $('#ventaExitosaModal').on('hidden.bs.modal', function() {
        // Limpiar el tbody
        $('#tableD').empty();

        // Limpiar los campos de código, select de productos y cantidad
        $('#codigo').val('');
        $('#producto').val('');
        $('#cantidad').val('');

        // Resetear los productos seleccionados y el total
        productosSeleccionados = [];
        total = 0;

        // Actualizar el total mostrado
        $('#total').text(total.toFixed(2));
    });
});

    
</script>



</body>
</html>
