<!doctype html>
<html lang="es">
<head>
    <title>Registro Usuarios</title>
    <style>
        .tabla-scrollable {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>

</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Formulario de registro -->
                <form id="formularioregistro" name="formularioregistro" action="registro.php" method="POST">
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email:</label>
                        <input type="email" class="form-control" name="Email" id="Email" placeholder=""/>
                        <div class="invalid-feedback" id="emailError">El Email es obligatorio</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="mb-3">
                                <label for="contrasenia" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="contrasenia" id="contrasenia" placeholder=""/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="RepetirContrasenia" class="form-label">Repetir Contraseña:</label>
                                <input type="password" class="form-control" name="RepetirContrasenia" id="RepetirContrasenia" placeholder=""/>
                                <div class="invalid-feedback" id="repetirError">Las contraseñas no coinciden</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="Rol" class="form-label">Rol:</label>
                            <select class="form-select" name="Rol" id="Rol">
                                <option value="Usuario">Usuario</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                            <div class="invalid-feedback" id="rolError">Debe seleccionar un rol</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="login.html" class="btn btn-primary">Login</a>
                </form>
            </div>

            <div class="col-md-6">
                <!-- Tabla de usuarios registrados -->
                <h4>Usuarios Registrados</h4>
                <div class="tabla-scrollable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Acción</th> <!-- Columna para el botón de eliminar -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once("./conexion.php");

                            // Obtener los registros de usuarios de la base de datos
                            try {
                                $pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $bd, $user, $pass);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $sql = "SELECT * FROM usuarios";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Mostrar los usuarios en la tabla
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr data-id='" . $row['id'] . "'>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['Rol'] . "</td>";
                                    // Botón de eliminación con confirmación de JavaScript
                                    echo "<td><a href='#' onclick='confirmDelete(" . $row['id'] . ")' class='btn btn-danger btn-sm'>Eliminar</a></td>";
                                    echo "</tr>";
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este Registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>


    <script>
    // Función para mostrar el modal y confirmar la eliminación
    function confirmDelete(id) {
        // Obtén el modal
        var myModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        
        // Muestra el modal
        myModal.show();

        // Evento cuando se hace clic en el botón de eliminar en el modal
        document.getElementById('confirmDelete').onclick = function() {
            // Realizar la eliminación con AJAX
            $.ajax({
                url: 'eliminar.php',  // Archivo PHP para procesar la eliminación
                type: 'POST',  // Usamos POST
                data: { id: id },  // Enviar el ID del registro
                success: function(response) {
                    if (response === 'success') {
                        // Cerrar el modal
                        myModal.hide();

                        // Eliminar la fila de la tabla
                        $('tr[data-id="' + id + '"]').remove();
                    } else {
                        alert('Error al eliminar el registro');
                    }
                },
                error: function() {
                    alert('Error al procesar la eliminación');
                }
            });
        };
    }
</script>

    <script>
    // Función para mostrar el modal y confirmar la eliminación

    // Manejo del formulario de registro con AJAX
 // Función para mostrar el modal y confirmar la eliminación

// Manejo del formulario de registro con AJAX
$(document).ready(function() {
    $('#formularioregistro').on('submit', function(e) {
        e.preventDefault();  // Prevenimos que el formulario se envíe de forma tradicional
        
        var formData = $(this).serialize();  // Recopilamos todos los datos del formulario
        
        $.ajax({
            url: 'registro.php',  // Archivo PHP que procesará el registro
            type: 'POST',
            data: formData,  // Enviamos los datos del formulario
            dataType: 'json',  // Esperamos que la respuesta sea en formato JSON
            success: function(response) {
    // Limpiar los errores previos
    $('.invalid-feedback').text('');
    $('.form-control').removeClass('is-invalid');

    // Si hay errores, los mostramos en los campos correspondientes
    if (response.errors) {
        if (response.errors.Email) {
            $('#Email').addClass('is-invalid');
            $('#emailError').text(response.errors.Email);
        }
        if (response.errors.contrasenia) {
            $('#contrasenia').addClass('is-invalid');
        }
        if (response.errors.RepetirContrasenia) {
            $('#RepetirContrasenia').addClass('is-invalid');
            $('#repetirError').text(response.errors.RepetirContrasenia);
        }
        if (response.errors.Rol) {
            $('#Rol').addClass('is-invalid');
            $('#rolError').text(response.errors.Rol);
        }
    } else if (response.success) {
        // Si el registro fue exitoso, actualizar la tabla
        alert('Registro exitoso');

        // Aseguramos que la tabla esté dentro del div con clase tabla-scrollable
        $('.tabla-scrollable table tbody').html(response.tabla);  // Actualizar la tabla en la página
        $('#formularioregistro')[0].reset(); 
    } else {
        alert('Error al registrar el usuario');
    }
},

            error: function() {
                alert('Error al enviar los datos');
            }
        });
    });
});

   
    </script>
</body>
</html>
