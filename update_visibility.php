<?php
require_once("./conexion.php");

if (isset($_POST['id']) && isset($_POST['visible'])) {
    $id = $_POST['id'];
    $visible = $_POST['visible'];

    $sql = "UPDATE registrousuarios SET visible = :visible WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['visible' => $visible, 'id' => $id]);

    if ($stmt->rowCount()) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
