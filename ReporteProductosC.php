<?php
date_default_timezone_set('America/Mexico_City');
require_once("./ConexionGeneral.php");

// Obtener los parámetros de búsqueda y fechas
$buscar = isset($_POST['buscar']) ? '%' . $_POST['buscar'] . '%' : null;
$fechaInicio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : null;
$fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : null;

// Construcción de la consulta SQL
$sql = "SELECT id_venta, id_producto, nombre_producto, cantidad, total_producto
        FROM productos_venta
        WHERE 1=1";

// Filtrar por búsqueda
if ($buscar) {
    $sql .= " AND nombre_producto LIKE :buscar";
}

// Filtrar por fechas
if ($fechaInicio && $fechaFin) {
    $sql .= " AND DATE(fecha_venta) BETWEEN :fechaInicio AND :fechaFin";
} elseif ($fechaInicio) {
    $sql .= " AND DATE(fecha_venta) >= :fechaInicio";
} elseif ($fechaFin) {
    $sql .= " AND DATE(fecha_venta) <= :fechaFin";
}

$stmt = $pdo->prepare($sql);

// Vincular parámetros
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

// Almacenar resultados y calcular el total vendido
$ventas = [];
$totalVendidoo = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $ventas[] = $row;
    $totalVendidoo += floatval($row['total_producto']); // Corregir la clave
}

// Devolver resultados como JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'ventas' => $ventas,
    'totalVendidoo' => $totalVendidoo
]);
