<?php
require_once("./conexion.php");

// Lógica de búsqueda
$buscar = isset($_POST['buscar']) ? $_POST['buscar'] : null;

if ($buscar) {
    $sql = "SELECT * FROM registrousuarios WHERE Nombre LIKE :buscar";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['buscar' => "%$buscar%"]);
} else {
    $sql = "SELECT * FROM registrousuarios WHERE visible = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
$output = '';
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $output .= "<tr data-id='" . $row["id"] . "'>";
    $output .= "<td>" . $row["id"] . "</td>";
    $output .= "<td>" . $row["Nombre"] . "</td>";
    $output .= "<td>" . $row["ApellidoPa"] . "</td>";
    $output .= "<td>" . $row["ApellidoMa"] . "</td>";
    $output .= "<td>" . $row["Edad"] . "</td>";
    $output .= "<td>" . $row["Telefono"] . "</td>";
    $output .= "<td>" . $row["Curp"] . "</td>";
    $output .= "<td>" . $row["SeguroSocial"] . "</td>";
    $output .= "<td>" . $row["Rfc"] . "</td>";
    $output .= "<td>" . $row["Puesto"] . "</td>";
    $output .= "</tr>";
}
echo $output;
?>