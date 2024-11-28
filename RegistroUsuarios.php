<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>GRUPO IBARRA</title>

    <!-- <style>
    /* Estilo personalizado para agregar margen superior al contenedor principal */
    .tabla-contenedor {
        width: 80%;
        /* Ajusta el ancho del contenedor de la tabla */
        margin: 80px auto;
        /* Centra el contenedor y añade margen superior e inferior */

    }
    </style> -->
</head>

<body>

<div class="modal fade" id="confirmEditModal" tabindex="-1" aria-labelledby="confirmEditModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmEditModal">Confirmar Edicion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Registro Actualizado con Exito
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmEdit">Confirmar</button>
            </div>
        </div>
    </div>
</div>


<form id="updateForm">
<div class="modal fade" id="updat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Personal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="Upid" name="id">
                <div class="mb-3">
                    <label for="Nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="UpNombre" name="Nombre" placeholder="Ingresa un Nombre">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="mb-3">
                            <label for="ApellidoPa" class="form-label">Apellido Paterno</label>
                            <input type="text" class="form-control" id="UpApellidoPa" name="ApellidoPa"
                                placeholder="Ingresa el Apellido Paterno" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="ApellidoMa" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control" id="UpApellidoMa" name="ApellidoMa"
                                placeholder="Ingresa el Apellido Materno">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="mb-3">
                            <label for="Edad" class="form-label">Edad</label>
                            <input type="text" class="form-control" id="UpEdad" name="Edad" placeholder="Ingresa la Edad">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="Telefono" class="form-label">Numero de Telefono</label>
                            <input type="text" class="form-control" id="UpTelefono" name="Telefono"
                                placeholder="Ingresa Numero de Telefono">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="Curp" class="form-label">Curp</label>
                    <input type="text" class="form-control" id="UpCurp" name="Curp" placeholder="Ingresa un Curp">
                </div>
                <div class="mb-3">
                    <label for="SeguroSocial" class="form-label">Numero Seguro Social</label>
                    <input type="text" class="form-control" id="UpSeguroSocial" name="SeguroSocial"
                        placeholder="Ingresa un Numero de Seguro Social">
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="mb-3">
                            <label for="Rfc" class="form-label">RFC</label>
                            <input type="text" class="form-control" id="UpRfc" name="Rfc" placeholder="Ingresa un RFC">
                        </div>
                    </div>
                    <div class="col">
                        <label for="Puesto" class="form-label">Puesto</label>
                        <select class="form-select" name="Puesto" id="UpPuesto" aria-label="Default select example">
                            <option selected>Oficina</option>
                            <option>Ayudante</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" id="actualizar" class="btn btn-outline-primary">Actualizar</button>
            </div>
        </div>
    </div>
</div>
</form>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres eliminar este registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>



    <form id="formRegistro" method="POST">
        

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Personal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>


                    <div class="modal-body">


                  
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="Nombre" name="Nombre"
                                placeholder="Ingresa un Nombre">
                        </div>


                        <div class="row mb-3">
                            <div class="col">


                                <div class="mb-3">
                                    <label for="ApellidoPa" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control" id="ApellidoPa" name="ApellidoPa"
                                        placeholder="Ingresa el Apellido Paterno" required>
                                </div>
                            </div>

                            <div class="col">

                                <div class="mb-3">
                                    <label for="ApellidoMa" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="ApellidoMa" name="ApellidoMa"
                                        placeholder="Ingresa el Apellido Materno">
                                </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">

                                <div class="mb-3">
                                    <label for="Edad" class="form-label">Edad</label>
                                    <input type="text" class="form-control" id="Edad" name="Edad"
                                        placeholder="Ingresa la Edad">
                                </div>
                            </div>

                            <div class="col">

                                <div class="mb-3">
                                    <label for="Telefono" class="form-label">Numero de Telefono</label>
                                    <input type="text" class="form-control" id="Telefono" name="Telefono"
                                        placeholder="Ingresa Numero de Telefono">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Curp" class="form-label">Curp</label>
                            <input type="text" class="form-control" id="Curp" name="Curp" placeholder="Ingresa un Curp">
                        </div>
                        <div class="mb-3">
                            <label for="SeguroSocial" class="form-label">Numero Seguro Social</label>
                            <input type="text" class="form-control" id="SeguroSocial" name="SeguroSocial"
                                placeholder="Ingresa un Numero de Seguro Social">
                        </div>


                        <div class="row mb-3">
                            <div class="col">

                                <div class="mb-3">
                                    <label for="Rfc" class="form-label">RFC</label>
                                    <input type="text" class="form-control" id="Rfc" name="Rfc"
                                        placeholder="Ingresa un RFC">
                                </div>
                            </div>

                            <div class="col">

                                <label for="formGroupExampleInput" class="form-label">Puesto</label>
                                <select class="form-select" name="Puesto" id="Puesto"
                                    aria-label="Default select example">
                                    <option selected>Oficina</option>
                                    <option>Ayudante</option>
                                </select>
                            </div>
                        </div>




                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <!-- <button type="button" class="btn btn-primary">Guardar</button> -->
                        <button type="submit" id="guardar" class="btn btn-outline-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>



   




    <div id="todoList">
        <?php
require_once("./conexion.php");

// Inserción de nuevos registros
if(isset($_POST['Nombre']) && isset($_POST['ApellidoPa']) && isset($_POST['ApellidoMa']) && isset($_POST['Edad']) && isset($_POST['Telefono']) && isset($_POST['Curp']) && isset($_POST['SeguroSocial']) && isset($_POST['Rfc']) && isset($_POST['Puesto'])){
    $Nombre= $_POST['Nombre'];
    $ApellidoPa= $_POST['ApellidoPa'];
    $ApellidoMa= $_POST['ApellidoMa'];
    $Edad= $_POST['Edad'];
    $Telefono= $_POST['Telefono'];
    $Curp= $_POST['Curp'];
    $SeguroSocial= $_POST['SeguroSocial'];
    $Rfc= $_POST['Rfc'];
    $Puesto= $_POST['Puesto'];

    $sql = "INSERT INTO registrousuarios (Nombre,ApellidoPa,ApellidoMa,Edad,Telefono,Curp,SeguroSocial,Rfc,Puesto) 
                    VALUES ('$Nombre','$ApellidoPa','$ApellidoMa','$Edad','$Telefono','$Curp','$SeguroSocial','$Rfc','$Puesto')";    
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $varID=$pdo->lastInsertId();
}

// Lógica de búsqueda
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : null;

if ($buscar) {
    $sql = "SELECT * FROM registrousuarios WHERE Nombre LIKE :buscar";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['buscar' => "%$buscar%"]);
} else {
    $sql = "SELECT * FROM registrousuarios";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

?>
    </div>

    <div class="tabla-contenedor">
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Agregar
                </button>
            </div>

            <div class="col">
                <div class="col-md-8">
                    <form method="POST" action="" class="d-flex">
                        <input id="buscar" name="buscar" class="form-control me-2" type="search"
                            placeholder="Buscar Empleado" aria-label="Search">
                        <button type="submit" class="btn btn-outline-success">Buscar</button>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Visible</th>
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
                    <th style="width: 150px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr data-id='" . $row["id"] . "'>";
            echo "<td><input type='checkbox' class='toggle-visibility' " . ($row['visible'] == 1 ? 'checked' : '') . "></td>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["Nombre"] . "</td>";
            echo "<td>" . $row["ApellidoPa"] . "</td>";
            echo "<td>" . $row["ApellidoMa"] . "</td>";
            echo "<td>" . $row["Edad"] . "</td>";
            echo "<td>" . $row["Telefono"] . "</td>";
            echo "<td>" . $row["Curp"] . "</td>";
            echo "<td>" . $row["SeguroSocial"] . "</td>";
            echo "<td>" . $row["Rfc"] . "</td>";
            echo "<td>" . $row["Puesto"] . "</td>";
            echo '<td>
                    <a href="editar.php" data-bs-toggle="modal" data-bs-target="#updat" 
                       onclick="loadData(' . htmlspecialchars($row['id']) . ')" class="me-2"><img src="./assets/edit.svg" class="list_img"></a> 
                   <a href="#" onclick="confirmDelete(' . htmlspecialchars($row['id']) . ')" class="ms-2"><img src="./assets/d.svg" class="list_img"></a>
                  </td>';
            echo "</tr>";
        }
        ?>          
            </tbody>
        </table>


    </div>


    <script src="./main.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>


  

    <script>
    $(document).ready(function() {
        
        $('#formRegistro').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: 'RegistroUsuarios.php',
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
            console.log(response);
            $('#todoList').load(location.href + " #todoList");
            alert('Registro exitoso');

            // Resetea el formulario
            $('#formRegistro')[0].reset();

            // Actualiza la tabla y oculta el modal
            actualizarTabla();
            $('#staticBackdrop').modal('hide');

            // Ajustar aria-hidden
            $('#staticBackdrop').attr('aria-hidden', 'true');
        },
        error: function () {
            alert('Error al registrar');
        }
    });
});
});

// Al abrir el modal, asegura que aria-hidden se actualice
$('#staticBackdrop').on('show.bs.modal', function () {
    $(this).attr('aria-hidden', 'false');
});

// Al cerrar el modal, asegura que aria-hidden se actualice
$('#staticBackdrop').on('hide.bs.modal', function () {
    $(this).attr('aria-hidden', 'true');
    $('#formRegistro')[0].reset(); // Limpia el formulario al cerrar
});
function actualizarTabla() {
    $.ajax({
        url: 'RegistroUsuarios.php', // Si la tabla ya se genera en este mismo archivo, puedes dejar el URL vacío
        type: 'POST',
        success: function(data) {
            // Actualizar la tabla con el contenido nuevo
            $('tbody').html($(data).find('tbody').html());
        },
        error: function(xhr, status, error) {
            alert('Error al recargar la tabla');
        }
    });
}

</script>


    <script>
    $(document).ready(function() {
        $('.toggle-visibility').on('change', function() {
            var checkbox = $(this);
            var id = checkbox.closest('tr').data('id');
            var visible = checkbox.is(':checked') ? 1 : 0;

            $.ajax({
                url: 'update_visibility.php',
                type: 'POST',
                data: {
                    id: id,
                    visible: visible
                },
                success: function(response) {
                    if (response != 'success') {
                        alert('Error al actualizar la visibilidad');
                    }
                }
            });
        });
    });
    </script>


<script>
    // Manejo del formulario de actualización usando AJAX
    $('#updateForm').on('submit', function(e) {
    e.preventDefault(); // Evita el envío normal del formulario
    var formData = $(this).serialize(); // Obtiene los datos del formulario

    $.ajax({
        url: 'editar.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            $('#updat').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            alert('Registro actualizado con éxito');
            // Llamar a la función para actualizar la tabla
            actualizarTabla(); 
        },
        error: function(xhr, status, error) {
            alert('Error al actualizar el registro');
            // $('#updat').modal('hide'); // Cierra el modal incluso si hay un error
            // $('body').removeClass('modal-open');
            // $('.modal-backdrop').remove();
        }
    });
});

// Función para actualizar solo la tabla después de la edición
function actualizarTabla() {
    $.ajax({
        url: 'RegistroUsuarios.php', // Si la tabla ya se genera en este mismo archivo, puedes dejar el URL vacío
        type: 'POST',
        success: function(data) {
            // Actualizar la tabla con el contenido nuevo
            $('tbody').html($(data).find('tbody').html());
        },
        error: function(xhr, status, error) {
            alert('Error al recargar la tabla');
        }
    });
}

    // Función para cargar datos al modal de actualización
    function loadData(id) {
        fetch('get_data.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('Upid').value = data.id;
                document.getElementById('UpNombre').value = data.Nombre;
                document.getElementById('UpApellidoPa').value = data.ApellidoPa;
                document.getElementById('UpApellidoMa').value = data.ApellidoMa;
                document.getElementById('UpEdad').value = data.Edad;
                document.getElementById('UpTelefono').value = data.Telefono;
                document.getElementById('UpCurp').value = data.Curp;
                document.getElementById('UpSeguroSocial').value = data.SeguroSocial;
                document.getElementById('UpRfc').value = data.Rfc;
                document.getElementById('UpPuesto').value = data.Puesto;
            });
    }
</script>

<!-- 
Eliminaciones -->
<script>


function confirmDelete(id) {
    $('#confirmDeleteModal').modal('show');
    $('#confirmDelete').off('click').on('click', function() {
        $.ajax({
            url: 'eliminar.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                if (response === 'success') {
                    $('#confirmDeleteModal').modal('hide');
                    alert('Registro eliminado con éxito');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    // Elimina la fila correspondiente de la tabla
                    $('tr[data-id="' + id + '"]').remove();
                } else {
                    alert('Error al eliminar el registro');
                }
            }
        });
    });
}



    // Resto de tu código JavaScript para cargar datos y actualizar
</script>


</body>

</html>