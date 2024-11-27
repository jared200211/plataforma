<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Reporte de Ventas</title>
    <style>
        .tabla-contenedor {
            margin-left: 200px;
        }
        .tabla-scrollable {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .total-vendido {
            font-size: 1.5em;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="tabla-contenedor">
    <div class="row mb-3">
        <div class="col">
            <input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2" aria-label="Fecha Inicio">
        </div>
        <div class="col">
            <input type="date" id="fechaFin" name="fechaFin" class="form-control me-2" aria-label="Fecha Fin">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-8">
            <form id="searchForm" class="d-flex">
                <input id="buscar" name="buscar" class="form-control me-2" type="search" placeholder="Buscar Empleado" aria-label="Search">
                <button type="submit" class="btn btn-outline-success">Buscar</button>
            </form>
        </div>
    </div>

    <div class="tabla-scrollable">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="tableDataaP">
                <!-- Las filas de la tabla se agregarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <div class="total-vendido" id="totalVendidoo">
        Total Vendido: $0.00
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(document).ready(function() {
    function loadTable(query = '', fechaInicio = '', fechaFin = '') {
        $.ajax({
            url: 'ReporteProductosC.php',
            method: 'POST',
            data: {
                buscar: query,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin
            },
            dataType: 'json',
            success: function(response) {
                if (response.ventas.length === 0) {
                    $('#tableDataaP').html('<tr><td colspan="5">No se encontraron ventas en el intervalo seleccionado.</td></tr>');
                    $('#totalVendidoo').text('Total Vendido: $0.00');
                } else {
                    let rows = '';
                    response.ventas.forEach(function(venta) {
                        let totalVenta = parseFloat(venta.total_producto) || 0;
                        rows += `
                            <tr>
                                <td>${venta.id_venta}</td>
                                <td>${venta.id_producto}</td>
                                <td>${venta.nombre_producto}</td>
                                <td>${venta.cantidad}</td>
                                <td>$${totalVenta.toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    $('#tableDataaP').html(rows);

                    let totalVendidoo = parseFloat(response.totalVendidoo) || 0;
                    $('#totalVendidoo').text('Total Vendido: $' + totalVendidoo.toFixed(2));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error AJAX: ', status, error);
                $('#tableDataaP').html('<tr><td colspan="5">Hubo un problema al cargar los datos.</td></tr>');
            }
        });
    }

    let today = new Date();
    let localDate = today.getFullYear() + '-' + 
                    String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                    String(today.getDate()).padStart(2, '0');

    loadTable('', localDate, localDate);

    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#buscar').val();
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();
        loadTable(query, fechaInicio, fechaFin);
    });

    setInterval(function() {
        loadTable($('#buscar').val(), $('#fechaInicio').val(), $('#fechaFin').val());
    }, 100);
});<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Reporte de Ventas</title>
    <style>
        .tabla-contenedor {
            margin-left: 200px;
        }
        .tabla-scrollable {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .total-vendido {
            font-size: 1.5em;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="tabla-contenedor">
    <div class="row jmb-3">
        <div class="col"><input type="date" id="fechaInicio" name="fechaInicio" class="form-control me-2" aria-label="Fecha Inicio"></div>
        <div class="col"><input type="date" id="fechaFin" name="fechaFin" class="form-control me-2" aria-label="Fecha Fin"></div>
    </div>

    <br>
    <!-- Filtros de búsqueda y fecha -->
    <div class="row mb-3">
        <div class="col">
            <div class="col-md-8">
                <form id="searchForm" class="d-flex">
                    <!-- Filtro de búsqueda por empleado -->
                    <input id="buscar" name="buscar" class="form-control me-2" type="search" placeholder="Buscar Empleado" aria-label="Search">
                    
                    <!-- Filtros de fechas -->
                    
                    <button type="submit" class="btn btn-outline-success">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="tabla-scrollable">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>ID Producto</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="tableDataaP">
                <!-- Las filas de la tabla se agregarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>
    <!-- Aquí mostramos el total vendido -->
    <div class="total-vendido" id="totalVendidoo">
        Total Vendido: $0.00
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(document).ready(function() {
    // Función para cargar los datos de la tabla con filtros
    function loadTable(query = '', fechaInicio = '', fechaFin = '') {
        $.ajax({
            url: 'ReporteProductosC.php',
            method: 'POST',
            data: {
                buscar: query,
                fechaInicio: fechaInicio,
                fechaFin: fechaFin
            },
            dataType: 'json',
            success: function(response) {
                // console.log(response);

                if (response.ventas.length === 0) {
                    $('#tableDataaP').html('<tr><td colspan="5">No se encontraron ventas en el intervalo seleccionado.</td></tr>');
                    $('#totalVendidoo').text('Total Vendido: $0.00');
                } else {
                    // Cargar las ventas en la tabla
                    let rows = '';
                    response.ventas.forEach(function(venta) {
                        let totalVenta = parseFloat(venta.total);
                        if (isNaN(totalVenta)) {
                            totalVenta = 0;
                        }

                        rows += `
                            <tr>
                                <td>${venta.id_venta}</td>
                                <td>${venta.id_producto}</td>
                                <td>${venta.nombre_producto}</td>
                                <td>${venta.cantidad}</td>
                                  <td>$${venta.total_producto}</td>
                            
                            </tr>
                        `;
                    });
                    $('#tableDataaP').html(rows);

                    // Mostrar el total vendido
                    let totalVendidoo = parseFloat(response.totalVendidoo);
                    if (isNaN(totalVendidoo)) {
                        totalVendidoo = 0;
                    }
                    $('#totalVendidoo').text('Total Vendido: $' + totalVendidoo.toFixed(2));
                }
            },
            error: function(xhr, status, error) {
                // console.error('Error AJAX: ', status, error);
                $('#tableDataaP').html('<tr><td colspan="5">Hubo un problema al cargar los datos.</td></tr>');
            }
        });
    }

    // Establecer la fecha de hoy como predeterminada

    let today = new Date();
let localDate = today.getFullYear() + '-' + 
                String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                String(today.getDate()).padStart(2, '0');

                // $('#fechaInicio').val(localDate);
                // $('#fechaFin').val(localDate);


  

    // Cargar la tabla con las ventas del día actual por defecto
    loadTable('', localDate, localDate);

    // Función para manejar la búsqueda
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        const query = $('#buscar').val();
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();
        loadTable(query, fechaInicio, fechaFin);
    });

    // Actualizar la tabla automáticamente cada 10 segundos
    setInterval(function() {
        loadTable($('#buscar').val(), $('#fechaInicio').val(), $('#fechaFin').val()); // Recarga la tabla según los filtros
    }, 1000);
});
</script>

</body>
</html>

</script>
</body>
</html>