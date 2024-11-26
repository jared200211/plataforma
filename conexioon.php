<?php
$conexion = null;
$servidor = "localhost";
$bd = "grupoindustrialibarra";
$user = "root";
$pass = "";

try {
    // Conexión a la base de datos
    $pdo = new PDO('mysql:host=' . $servidor . ';dbname=' . $bd . ';charset=utf8', $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Activar el manejo de errores con excepciones

    // Verificar si se recibe un id_producto para hacer la búsqueda
    if (isset($_GET['codigo'])) {
        $codigo = $_GET['codigo'];  // Este es el id_producto que ingresa el usuario

        // Buscar producto por id_producto
        $sql = "SELECT id_producto, nombre_producto, precio_unitario FROM inventario WHERE id_producto = :codigo";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':codigo', $codigo, PDO::PARAM_INT);
        $statement->execute();
        $producto = $statement->fetch(PDO::FETCH_ASSOC);

        if ($producto) {
            echo json_encode($producto);  // Devuelve el producto encontrado
        } else {
            echo json_encode(["error" => "Producto no encontrado"]);  // Si no se encuentra el producto
        }
    } else {
        // Si no se pasa código, obtener todos los productos
        $sql = "SELECT id_producto, nombre_producto, precio_unitario FROM inventario";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $productos = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($productos) > 0) {
            echo json_encode($productos);  // Devuelve todos los productos
        } else {
            echo json_encode(["error" => "No se encontraron productos disponibles."]);  // Si no hay productos en la base de datos
        }
    }

} catch (PDOException $e) {
    // En caso de error en la conexión o la consulta, devolvemos un mensaje de error en formato JSON
    echo json_encode(["error" => "Error en la conexión o consulta: " . $e->getMessage()]);
    exit;
}
?>
