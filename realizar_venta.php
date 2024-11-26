<?php
// realizar_venta.php

// Inicia la sesión para capturar errores
ini_set('display_errors', 0);  // Desactiva mostrar errores al usuario
ini_set('log_errors', 1);      // Activa el log de errores
ini_set('error_log', '/path/to/php-error.log'); // Especifica un archivo de log

include './conexioon.php'; // Incluye la conexión a la base de datos

// Recolectar los datos enviados
$vendedor = $_POST['vendedor'];
$tipo_pago = $_POST['tipo_pago'];
$total = $_POST['total'];
$productosVenta = json_decode($_POST['productosVenta'], true); // Renombramos la variable a productosVenta

try {
    // Iniciar la transacción con PDO
    $pdo->beginTransaction();

    // Insertar en la tabla ventas
    $query = "INSERT INTO ventas (tipo_pago, Vendedor, total) VALUES (:tipo_pago, :vendedor, :total)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':tipo_pago', $tipo_pago, PDO::PARAM_STR);
    $statement->bindParam(':vendedor', $vendedor, PDO::PARAM_STR);
    $statement->bindParam(':total', $total, PDO::PARAM_STR);
    if (!$statement->execute()) {
        throw new Exception("Error al insertar venta");
    }

    // Obtener el id de la venta recién insertada
    $id_venta = $pdo->lastInsertId();

    // Insertar los productos en la tabla productos_venta
    $productos_vendidos = [];
    foreach ($productosVenta as $producto) {
        $id_producto = $producto['id_producto'];
        $nombre_producto = $producto['nombre_producto'];
        $cantidad = $producto['cantidad'];
        $precio_unitario = $producto['precio_unitario'];
        $total_producto = $producto['total_producto'];

        $query = "INSERT INTO productos_venta (id_venta, id_producto, nombre_producto, cantidad, precio_unitario, total_producto)
                  VALUES (:id_venta, :id_producto, :nombre_producto, :cantidad, :precio_unitario, :total_producto)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id_venta', $id_venta, PDO::PARAM_INT);
        $statement->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
        $statement->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
        $statement->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);  // Utilizamos PDO::PARAM_INT para la cantidad
        $statement->bindParam(':precio_unitario', $precio_unitario, PDO::PARAM_STR); // Si es decimal
        $statement->bindParam(':total_producto', $total_producto, PDO::PARAM_STR);  // Usamos PDO::PARAM_STR para total_producto

        if (!$statement->execute()) {
            throw new Exception("Error al insertar producto en productos_venta");
        }

        // Almacenar los productos vendidos para responder
        $productos_vendidos[] = [
            'id_producto' => $id_producto,
            'nombre_producto' => $nombre_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario,
            'total_producto' => $total_producto
        ];
    }

    // Commit de la transacción
    $pdo->commit();

    // Responder con el éxito y los productos vendidos
    echo json_encode([
        "success" => true,
        "message" => "Venta realizada con éxito",
        "venta_id" => $id_venta,
        "productos_vendidos" => $productos_vendidos
    ]);

} catch (Exception $e) {
    // Rollback en caso de error
    $pdo->rollBack();

    // Registrar el error
    error_log($e->getMessage());

    // Responder con el error
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
