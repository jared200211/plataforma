<?php
// Ruta: ruta_a_tu_api_o_php_de_venta.php

try {
    // Conectar a la base de datos con PDO
    include './conexioon.php'; // Incluye la conexión a la base de datos


    // Obtener datos enviados desde la solicitud AJAX
    $vendedor = $_POST['vendedor'];
    $tipo_pago = $_POST['tipo_pago'];
    $total = $_POST['total'];
    $productos = $_POST['productos'];

    // Iniciar la transacción
    $pdo->beginTransaction();

    // Insertar la venta en la tabla 'ventas'
    $stmt = $pdo->prepare("INSERT INTO ventas (tipo_pago, Vendedor, total) VALUES (?, ?, ?)");
    $stmt->execute([$tipo_pago, $vendedor, $total]);
    $id_venta = $pdo->lastInsertId(); // Obtener el ID de la venta recién insertada

    // Insertar los productos de la venta en la tabla 'productos_venta'
    $stmt = $pdo->prepare("INSERT INTO productos_venta (id_venta, id_producto, nombre_producto, cantidad, precio_unitario, total_producto) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($productos as $producto) {
        $stmt->execute([
            $id_venta,
            $producto['id_producto'],
            $producto['nombre_producto'],
            $producto['cantidad'],
            $producto['precio_unitario'],
            $producto['total_producto']
        ]);
    }

    // Confirmar la transacción
    $pdo->commit();

    // Respuesta exitosa
    echo json_encode(["success" => true]);

} catch (PDOException $e) {
    // En caso de error, revertir los cambios
    $pdo->rollBack();
    
    // Responder con el mensaje de error
    echo json_encode([
        "success" => false,
        "message" => "Error al realizar la venta: " . $e->getMessage()
    ]);
}
?>
