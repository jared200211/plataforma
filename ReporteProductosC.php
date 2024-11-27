<?php
date_default_timezone_set('America/Mexico_City');


require_once("./ConexionGeneral.php");

// Obtener los parámetros de búsqueda y fechas
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : null;
$fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
$fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;

// Construcción de la consulta SQL
$sql = "SELECT id_venta,id_producto, nombre_producto, cantidad, total_producto FROM productos_venta WHERE 1=1";

// Filtrar por vendedor
if ($buscar) {
    $sql .= " AND vendedor LIKE :buscar";
}

// Filtrar por fechas, si las fechas están presentes
if ($fechaInicio && $fechaFin) {
    $sql .= " AND fecha_venta BETWEEN :fechaInicio AND :fechaFin";
} elseif ($fechaInicio) {
    $sql .= " AND fecha_venta >= :fechaInicio";
} elseif ($fechaFin) {
    $sql .= " AND fecha_venta <= :fechaFin";
}

$stmt = $pdo->prepare($sql);

// Vincular los parámetros
if ($buscar) {
    $stmt->bindParam(':buscar', $buscar);
}
if ($fechaInicio) {
    $stmt->bindParam(':fechaInicio', $fechaInicio);
}
if ($fechaFin) {
    $stmt->bindParam(':fechaFin', $fechaFin);
}

$stmt->execute();

// Variables para almacenar los resultados de las ventas y el total vendido
$ventas = [];
$totalVendidoo = 0;

// Obtenemos todas las filas y las sumamos a un array
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ventas[] = $row;
    $totalVendidoo += $row['total_producto']; // Sumar el total de cada venta
}

// Devolvemos los datos como un array JSON (ventas y total)
echo json_encode([
    'ventas' => $ventas,
    'totalVendidoo' => $totalVendidoo // Total de ventas
]);
?>
