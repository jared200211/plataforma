<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    require_once("./conexion.php");

    $Email = isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : null;
    $contrasenia = isset($_POST['contrasenia']) ? $_POST['contrasenia'] : null;

    
    $response = ['success' => false, 'message' => ''];

   
    if (empty($Email) || empty($contrasenia)) {
        $response['message'] = "Ingrese un Usuario y Contraseña válidos.";
        echo json_encode($response);
        exit();
    }

    try {
       
        $pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $bd, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consultar si el usuario con ese Email existe
        $sql = "SELECT id, Email, contrasenia, Rol FROM usuarios WHERE Email = :Email";
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute(['Email' => $Email]);

        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

        // Verificar la contraseña y que el usuario exista
        if ($usuario && password_verify($contrasenia, $usuario["contrasenia"])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['Email'];
            $_SESSION['usuario_rol'] = $usuario['Rol'];

            // Login exitoso, enviamos una respuesta positiva
            $response['success'] = true;
            $response['message'] = "Login exitoso.";
        } else {
            // Si el correo o la contraseña son incorrectos
            $response['message'] = "Usuario o Contraseña Incorrectos.";
        }

        // Devolvemos la respuesta JSON
        echo json_encode($response);
        exit();

    } catch (PDOException $e) {
        // Error de conexión
        $response['message'] = "Error de conexión a la base de datos.";
        echo json_encode($response);
        exit();
    }
}


?>