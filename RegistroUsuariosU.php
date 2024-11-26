<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>GRUPO IBARRA</title>

    <!-- <style>
    /* Estilo personalizado para agregar margen superior al contenedor principal */
    .tabla-contenedor {
        width: 80%;
        margin: 80px auto;
    }
    </style> -->
</head>
<body>

<div class="tabla-contenedor">
    <div class="row mb-3">
        <div class="col">
        </div>
        <div class="col">
           <div class="col-md-8">
                <form id="searchForm" class="d-flex">
                    <input id="buscar" name="buscar" class="form-control me-2" type="search" placeholder="Buscar Empleado" aria-label="Search">
                    <button type="submit" class="btn btn-outline-success">Buscar</button>
                </form>
            </div> 
        </div>
    </div>

    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Edad</th>
                <th>Telefono</th>
                <th>Curp</th>
                <th>Num Social</th>
                <th>Rfc</th>
                <th>Puesto</th>
            </tr>
        </thead>
        <tbody id="tableData">
            <!-- Aquí se cargarán los datos con AJAX -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para cargar los datos de la tabla
        function loadTable(query = '') {
            $.ajax({
                url: 'actRegistroU.php',
                method: 'POST',
                data: { buscar: query },
                success: function(data) {
                    $('#tableData').html(data); // Cargar los datos en el tbody
                }
            });
        }

        // Cargar la tabla al cargar la página
        loadTable();

        // Función para manejar la búsqueda
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            const query = $('#buscar').val();
            loadTable(query);
        });

        // Actualizar la tabla automáticamente cada 10 segundos
        setInterval(function() {
            loadTable($('#buscar').val()); // Recarga la tabla según el término de búsqueda actual
        }, 1000); // 10 segundos
    });
</script>

</body>
</html>
