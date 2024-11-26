<?php
require_once("./conexion.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $Nombre = $_POST['Nombre'];
    $ApellidoPa = $_POST['ApellidoPa'];
    $ApellidoMa = $_POST['ApellidoMa'];
    $Edad = $_POST['Edad'];
    $Telefono = $_POST['Telefono'];
    $Curp = $_POST['Curp'];
    $SeguroSocial = $_POST['SeguroSocial'];
    $Rfc = $_POST['Rfc'];
    $Puesto = $_POST['Puesto'];

    $sql = "UPDATE registrousuarios SET 
            Nombre = :Nombre,
            ApellidoPa = :ApellidoPa,
            ApellidoMa = :ApellidoMa,
            Edad = :Edad,
            Telefono = :Telefono,
            Curp = :Curp,
            SeguroSocial = :SeguroSocial,
            Rfc = :Rfc,
            Puesto = :Puesto
            WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'Nombre' => $Nombre,
        'ApellidoPa' => $ApellidoPa,
        'ApellidoMa' => $ApellidoMa,
        'Edad' => $Edad,
        'Telefono' => $Telefono,
        'Curp' => $Curp,
        'SeguroSocial' => $SeguroSocial,
        'Rfc' => $Rfc,
        'Puesto' => $Puesto,
        'id' => $id
    ]);
}
?>
