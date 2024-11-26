<?php
// delete.php
require_once("./conexion.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepara la consulta para eliminar el registro de RegistroUsuarios.php
    $sql = "DELETE FROM registrousuarios WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);

    //Hace la eliminación de registroo.php
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(['id' => $id]);

    // Respuesta de éxito
    echo "success";
} else {
    // Respuesta de error
    echo "error";
}

?>
