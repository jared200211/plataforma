<?php
require_once("./conexion.php");

$errores = array();
$success = false;

// Recibimos los datos del formulario
$Email = isset($_POST["Email"]) ? $_POST['Email'] : null;
$contrasenia = isset($_POST["contrasenia"]) ? $_POST['contrasenia'] : null;
$RepetirContrasenia = isset($_POST["RepetirContrasenia"]) ? $_POST['RepetirContrasenia'] : null;
$Rol = isset($_POST["Rol"]) ? $_POST['Rol'] : null;

// Validación del Email
if (empty($Email)) {
    $errores['Email'] = "Debe ingresar un Email";
} elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
    $errores['Email'] = "Formato de Correo Incorrecto";
}

// Validación de la contraseña
if (empty($contrasenia)) {
    $errores['contrasenia'] = "La contraseña es obligatoria";
} elseif ($contrasenia != $RepetirContrasenia) {
    $errores['RepetirContrasenia'] = "Las Contraseñas no coinciden";
}

// Si hay errores, devolverlos en formato JSON
if (!empty($errores)) {
    echo json_encode(['errors' => $errores]);
    exit;
}

try {
    // Conectar a la base de datos
    $pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $bd, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hash de la contraseña
    $nuevaContrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);

    // Insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO `usuarios` (`Email`, `contrasenia`, `Rol`) VALUES (:Email, :contrasenia, :Rol)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':Email' => $Email,
        ':contrasenia' => $nuevaContrasenia,
        ':Rol' => $Rol
    ]);

    // Obtener la tabla actualizada de usuarios
    $sql = "SELECT * FROM usuarios";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Generar el HTML de la tabla con los usuarios actuales
    $tabla = '';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tabla .= "<tr data-id='" . $row['id'] . "'>";
        $tabla .= "<td>" . $row['id'] . "</td>";
        $tabla .= "<td>" . $row['Email'] . "</td>";
        $tabla .= "<td>" . $row['Rol'] . "</td>";
        $tabla .= "<td><a href='#' onclick='confirmDelete(" . $row['id'] . ")' class='btn btn-danger btn-sm'>Eliminar</a></td>";
        $tabla .= "</tr>";
    }

    // Si todo va bien, devolver éxito y la nueva tabla
    echo json_encode(['success' => true, 'tabla' => $tabla]);

} catch (PDOException $e) {
    // Si ocurre un error en la conexión a la base de datos
    echo json_encode(['error' => 'Hubo un error al registrar el usuario: ' . $e->getMessage()]);
}
?>
