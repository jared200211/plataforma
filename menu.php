<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GRUPO IBARRA</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

 
    <style>

body {
            display: flex;
            margin: 0; /* Sin márgenes */
        }
        #content {
    min-height: 100vh;   /* Asegura que el contenido ocupe toda la ventana */
    margin-left: 300px;  /* Deja espacio para el menú fijo */
    padding: 15px;
    overflow-x: auto;    /* Asegura que el contenido no se desborde horizontalmente */
}
        
.nav {
    position: fixed; /* Fijo */
    top: 0;          /* Alineado al top */
    left: 0;         /* Alineado a la izquierda */
    height: 100%;    /* Ocupa toda la altura de la ventana */
    width: 300px;    /* Ancho fijo */
   
    background: #fff; /* Fondo blanco */
    z-index: 1000;   /* Asegúrate de que esté por encima de otros elementos */
}

    
    </style>
    <link rel="stylesheet" href="./css/estilos.css">

</head>
<body>
    <nav class="nav">
        <ul class="list">
            <li class="list_item">
                <div class="list_button">
                    <img src="./assets/home.svg" class="list_img">
                    <a href="#" class="nav_link">Inicio</a>
                </div>
            </li>

            <li class="list_item list_item--click">
             <span class="arrow"></span>
                <div class="list_button list_button--click">
                    
                    <img src="./assets/ven.svg" class="list_img">
                    <a href="#" class="nav_link">Ventas</a>
                    <img src="./assets/flecha.svg" class="list_arrow">
                </div>
                <ul class="list_show">
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside menu-option" data-page="ventas.php">Nueva Venta</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Nuevo Servicio</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Estoy dentro</a>
                    </li>
                </ul>
            </li>

            <li class="list_item list_item--click">
                <div class="list_button list_button--click">
                    <img src="./assets/inventario.svg" class="list_img">
                    <a href="#" class="nav_link">Cotizaciones</a>
                    <img src="./assets/flecha.svg" class="list_arrow">
                </div>
                <ul class="list_show">
                    <li class="list_inside">
                    <a href="#" class="nav_link nav_link--inside menu-option" data-page="nuevaCotizacion.php">Nueva Cotizacion</a>
                       
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Inventario Actual</a>
                    </li>
                </ul>
            </li>

            <li class="list_item list_item--click">
                <div class="list_button list_button--click">
                    <img src="./assets/repor.svg" class="list_img">
                    <a href="#" class="nav_link">Reportes</a>
                    <img src="./assets/flecha.svg" class="list_arrow">
                </div>
                <ul class="list_show">
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside menu-option" data-page="ReporteVentas.php">Reporte Ventas</a>
                    </li>
                    <li class="list_inside">
                    <a href="#" class="nav_link nav_link--inside menu-option" data-page="ReporteProductos.php">Reporte Productos</a>
                      
                    </li>
                    <li class="list_inside">
                    <a href="#" class="nav_link nav_link--inside menu-option" data-page="gastos.php">Reporte Gastos</a>
                       
                    </li>
                </ul>
            </li>

            <li class="list_item list_item--click">
                <div class="list_button list_button--click">
                    <img src="./assets/inventario.svg" class="list_img">
                    <a href="#" class="nav_link">Inventario</a>
                    <img src="./assets/flecha.svg" class="list_arrow">
                </div>
                <ul class="list_show">
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Ingresar Productos</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Inventario Actual</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside">Estoy dentro</a>
                    </li>
                </ul>
            </li>

            <li class="list_item list_item--click">
                <div class="list_button list_button--click">
                    <img src="./assets/personal.svg" class="list_img">
                    <a href="#" class="nav_link">Personal</a>
                    <img src="./assets/flecha.svg" class="list_arrow">
                </div>
                <ul class="list_show">
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside menu-option" data-page="RegistroUsuariosU.php">Lista Empleados</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside menu-option" data-page="RegistroUsuarios.php">Registro Empleados</a>
                    </li>
                    <li class="list_inside">
                        <a href="#" class="nav_link nav_link--inside menu-option" data-page="registroo.php">Registro Usuarios</a>
                    </li>
                </ul>
            </li>

            <li class="list_item">
                <div class="list_button">
                    <img src="./assets/exit.svg" class="list_img">
                    <a href="index.php" class="nav_link">Cerrar Sesion</a>
                </div>
            </li>
        </ul>
    </nav>
    
    <div id="content">
        <!-- Contenido dinámico se cargará aquí -->
        <h1>Bienvenido a Grupo Ibarra</h1>
        <p>Selecciona una opción del menú.</p>
    </div>

    <script src="./main.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>


        <script>
    $(document).ready(function() {
        // Manejar los clics del menú y cargar contenido dinámico
        $('.menu-option').on('click', function(e) {
            e.preventDefault();  // Prevenir el comportamiento por defecto del enlace

            // Eliminar clase activa de todos los elementos del menú
            $('.menu-option').removeClass('active');

            // Agregar clase activa al elemento seleccionado
            $(this).addClass('active');

            var page = $(this).data('page');  // Obtener la página que se debe cargar

            // Hacer la petición AJAX para cargar el contenido
            $.ajax({
                url: page,  // Página PHP a cargar
                type: 'GET',
                success: function(response) {
                    $('#content').html(response);  // Insertar el contenido en el div
                },
                error: function() {
                    $('#content').html('<p>Ocurrió un error al cargar la página.</p>');
                }
            });
        });
    });
</script>

   

</body>
</html>

